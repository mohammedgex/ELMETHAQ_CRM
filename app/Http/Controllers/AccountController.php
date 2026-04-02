<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date; // مهم جداً لحل مشكلة تاريخ 1970

class AccountController extends Controller
{
    // عرض كشف حساب عميل
    public function index($customer_id)
    {
        // جلب العميل مع علاقاته
        $customer = Customer::with(['accounts', 'paymentTitles'])->findOrFail($customer_id);

        // جلب كافة الحركات لعرضها في السجل (الجدول)
        $accounts = $customer->accounts()->latest()->get();

        // حساب الإجماليات مع استثناء "الشراء" من الجمع والطرح
        // نستخدم filter لاستبعاد القيود التي وصفها "شراء" فقط من عملية الحساب
        $totalDebit = $accounts->where('description', '!=', 'شراء')->sum('debit');
        $totalCredit = $accounts->where('description', '!=', 'شراء')->sum('credit');

        // الرصيد النهائي بناءً على الحسابات المستثنى منها الشراء
        $balance = $totalDebit - $totalCredit;

        return view('accounts.index', compact(
            'customer',
            'accounts',
            'totalDebit',
            'totalCredit',
            'balance'
        ));
    }

    // صفحة إضافة عملية
    public function create($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        return view('accounts.create', compact('customer'));
    }

    // حفظ العملية
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        Account::create([
            'customer_id' => $request->customer_id,
            'debit' => $request->debit ?? 0,
            'credit' => $request->credit ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->back()
            ->with('success', 'تم إضافة العملية بنجاح');
    }

    public function customersSummary($group_id)
    {
        $customers = Customer::where('customer_group_id', $group_id)
            ->withSum(['accounts as total_debit' => function ($query) {
                $query->where('description', '!=', 'شراء');
                // أو إذا كنت تريد استبعاد أي وصف يحتوي على كلمة شراء:
                // $query->where('description', 'not like', '%شراء%');
            }], 'debit')
            ->withSum(['accounts as total_credit' => function ($query) {
                $query->where('description', '!=', 'شراء');
            }], 'credit')
            ->get();

        foreach ($customers as $customer) {
            $customer->balance =
                ($customer->total_debit ?? 0) -
                ($customer->total_credit ?? 0);
        }

        return view('accounts.customers-summary', compact('customers', 'group_id'));
    }
    public function customersSearch(Request $request)
    {
        $search = $request->q;
        $groupId = $request->group_id; // جلب الـ group_id لو موجود

        $query = \App\Models\Customer::query();

        // فلتر بالاسم
        if ($search) {
            $query->where('name_ar', 'LIKE', "%{$search}%");
        }

        // فلتر حسب المجموعة لو معرف
        if ($groupId) {
            $query->where('customer_group_id', $groupId);
        }

        $customers = $query->limit(20)->get();

        return response()->json(
            $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'text' => $customer->name_ar
                ];
            })
        );
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return back()->with('success', 'تم حذف القيد بنجاح');
    }

    public function accDay(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $accounts = Account::with('customer')->whereDate('created_at', $date)->get();

        // الحسابات المالية
        $totalDebit = $accounts->sum('debit');
        $totalCredit = $accounts->sum('credit');
        $netBalance = $totalDebit - $totalCredit; // صافي الحركة

        return view('accounts.acc-day', compact('accounts', 'date', 'totalDebit', 'totalCredit', 'netBalance'));
    }


    public function showImportPage()
    {
        return view('accounts.import');
    }
    public function processImport(Request $request)
    {
        $request->validate(['excel_file' => 'required|mimes:xlsx,xls,csv']);

        // قراءة الشيت كمصفوفة
        $data = \Excel::toArray([], $request->file('excel_file'))[0];

        // استخراج البيانات وتخزينها بالسيشن
        $cleanData = collect($data)->slice(2);
        session(['excel_data' => $cleanData->toArray()]);

        // جلب الأسماء الفريدة من العمود الأول
        $excelCustomers = $cleanData->pluck(0)->unique()->filter()->toArray();

        $customersList = [];
        foreach ($excelCustomers as $excelName) {
            // 1. استخراج الاسم فقط وتجاهل أي شيء قبل الـ "/" (مثل السائق / ...)
            $rawName = preg_replace('/^.*?\/\s*/u', '', $excelName);

            // إذا كان هناك "-" نفصل ونأخذ الجزء الثاني (الاسم) فقط
            if (str_contains($rawName, '-')) {
                $parts = explode('-', $rawName);
                $displayName = trim(end($parts)); // نأخذ آخر جزء بعد الشرطة كونه غالباً هو الاسم
            } else {
                $displayName = trim($rawName);
            }

            // 2. تطهير الاسم للبحث (Normalize)
            $searchName = $this->normalizeArabic($displayName);

            // 3. البحث في السيستم (بالاسم فقط مع تجاهل فروقات الهمزات والتاء المربوطة في الطرفين)
            $systemCustomer = \App\Models\Customer::where(function ($query) use ($searchName) {
                $query->whereRaw("
                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(name_ar, 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ة', 'ه'), 'ى', 'ي') 
                LIKE ?", ["%" . $searchName . "%"]);
            })->first();

            // 4. محاولة أخيرة: إذا لم يجد، نبحث بالاسم الأصلي كما هو
            if (!$systemCustomer) {
                $systemCustomer = \App\Models\Customer::where('name_ar', 'like', '%' . $displayName . '%')->first();
            }

            $customersList[] = [
                'excel_original' => $excelName,
                'display_name'   => $displayName,
                'system_id'      => $systemCustomer ? $systemCustomer->id : null,
                'system_name'    => $systemCustomer ? $systemCustomer->name_ar : null,
                'status'         => $systemCustomer ? 'found' : 'not_found'
            ];
        }

        return view('accounts.mapping', compact('customersList'));
    }

    /**
     * دالة موحدة لتطهير النصوص العربية
     * تقوم بتحويل كل الأشكال الممكنة لحرف واحد لضمان المطابقة
     */
    private function normalizeArabic($string)
    {
        if (empty($string)) return "";

        // إزالة الحركات (فتحة، ضمة، إلخ)
        $tashkeel = ["/ُ/", "/ً/", "/ٌ/", "/َّ/", "/ِ/", "/ٍ/", "/ْ/", "/َ/"];
        $string = preg_replace($tashkeel, "", $string);

        $entities = [
            '/[أإآ]/u' => 'ا',
            '/[ة]/u'    => 'ه',
            '/[ى]/u'    => 'ي',
            '/[ئ]/u'    => 'ي',
            '/[ؤ]/u'    => 'و',
        ];

        $string = preg_replace(array_keys($entities), array_values($entities), $string);

        // إزالة أي مسافات زائدة في المنتصف
        $string = preg_replace('/\s+/', ' ', $string);

        return trim($string);
    }

    public function finalConfirm(Request $request)
    {
        // 1. جلب البيانات من السيشن والفورم
        $excelData = session('excel_data');
        $mapping = $request->input('mapping');

        // 2. التحقق من وجود البيانات ومن ربط كل الحقول (Validation)
        if (!$excelData || !$mapping) {
            return redirect()->back()->with('error', 'انتهت صلاحية الجلسة أو البيانات غير موجودة.');
        }

        foreach ($mapping as $entry) {
            if (empty($entry['customer_id'])) {
                return redirect()->back()
                    ->with('error', 'خطأ: لا يمكن الحفظ! يجب ربط جميع الأسماء في الجدول بعملاء من النظام.')
                    ->withInput();
            }
        }

        // 3. بدء عملية الحفظ الفعلي
        DB::beginTransaction();

        try {
            foreach ($excelData as $row) {
                $excelName = $row[0]; // اسم العميل في الشيت

                // البحث عن العميل المختار لهذا الاسم في مصفوفة الربط
                $mappedCustomer = collect($mapping)->firstWhere('excel_name', $excelName);

                if ($mappedCustomer && !empty($mappedCustomer['customer_id'])) {

                    $invoiceRaw = $row[2] ?? ''; // نص الفاتورة
                    $dateRaw = $row[1] ?? null;  // التاريخ من الإكسيل

                    // --- معالجة التاريخ الذكية (لحل مشكلة 19-10-1970) ---
                    $finalDate = Carbon::now();
                    if ($dateRaw) {
                        try {
                            // إذا كان الإكسيل يرسل التاريخ كـ "رقم تسلسلي" (مثل 45949)
                            if (is_numeric($dateRaw)) {
                                $finalDate = Carbon::instance(Date::excelToDateTimeObject($dateRaw))->setTime(10, 0, 0);
                            } else {
                                // إذا كان التاريخ نصاً بصيغة شهر/يوم/سنة
                                $finalDate = Carbon::createFromFormat('m/d/Y', trim($dateRaw))->setTime(10, 0, 0);
                            }
                        } catch (\Exception $e) {
                            try {
                                // محاولة أخيرة مرنة في حال اختلف التنسيق
                                $finalDate = Carbon::parse($dateRaw)->setTime(10, 0, 0);
                            } catch (\Exception $e2) {
                                $finalDate = Carbon::now(); // في حال الفشل التام نأخذ تاريخ اليوم
                            }
                        }
                    }

                    // --- تنظيف الوصف ---
                    $finalDescription = '';
                    if (str_contains($invoiceRaw, 'شراء')) {
                        $finalDescription = 'شراء';
                    } else {
                        // أي حالة أخرى نكتب النص كما هو مع التاريخ الأصلي
                        $finalDescription = trim($invoiceRaw) . ' بتاريخ ' . $dateRaw;
                    }

                    // --- تنفيذ القيد في قاعدة البيانات ---
                    \App\Models\Account::create([
                        'customer_id' => $mappedCustomer['customer_id'],
                        'debit'       => isset($row[6]) ? (float)str_replace(',', '', $row[6]) : 0,
                        'credit'      => isset($row[4]) ? (float)str_replace(',', '', $row[4]) : 0,
                        'description' => $finalDescription,
                        'created_at'  => $finalDate,
                        'updated_at'  => $finalDate,
                    ]);
                }
            }

            // 4. الاعتماد النهائي ومسح الذاكرة المؤقتة
            DB::commit();
            session()->forget('excel_data');

            return redirect()->route('import.view')->with('success', 'تم استيراد كافة القيود بنجاح بالتواريخ الصحيحة.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'حدث خطأ تقني أثناء الحفظ: ' . $e->getMessage());
        }
    }
}
