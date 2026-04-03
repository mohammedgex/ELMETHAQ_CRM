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


    public function showImportPage($group_id)
    {
        return view('accounts.import', compact('group_id'));
    }
    public function processImport(Request $request, $group_id)
    {
        $request->validate(['excel_file' => 'required|mimes:xlsx,xls,csv']);

        // 1. قراءة الملف وتخزينه مؤقتاً
        $data = \Excel::toArray([], $request->file('excel_file'))[0];
        $cleanData = collect($data)->slice(2); // تجاهل الهيدر
        session(['excel_data' => $cleanData->toArray()]);

        // 2. جلب الأسماء الفريدة من الإكسيل للربط اليدوي
        $allExcelNames = $cleanData->pluck(0)->unique()->filter()->values()->all();

        // 3. جلب عملاء السيستم للمجموعة المحددة
        $systemCustomers = \App\Models\Customer::where('customer_group_id', $group_id)->get();

        $customersList = [];
        foreach ($systemCustomers as $customer) {
            $searchName = $this->normalizeArabic($customer->name_ar);

            // محاولة إيجاد تطابق آلي
            $foundInExcel = $cleanData->first(function ($row) use ($searchName) {
                return str_contains($this->normalizeArabic($row[0] ?? ''), $searchName);
            });

            $customersList[] = [
                'system_id'      => $customer->id,
                'system_name'    => $customer->name_ar,
                'excel_original' => $foundInExcel ? $foundInExcel[0] : null,
                'status'         => $foundInExcel ? 'found' : 'not_found'
            ];
        }

        return view('accounts.mapping', compact('customersList', 'allExcelNames', 'group_id'));
    }
    private function normalizeArabic($string, $removeSpaces = false)
    {
        if (empty($string)) return "";

        // 1. إزالة التشكيل
        $tashkeel = ["/ُ/", "/ً/", "/ٌ/", "/َّ/", "/ِ/", "/ٍ/", "/ْ/", "/َ/"];
        $string = preg_replace($tashkeel, "", $string);

        // 2. توحيد الحروف الضعيفة
        $entities = [
            '/[أإآ]/u' => 'ا',
            '/[ة]/u'    => 'ه',
            '/[ى]/u'    => 'ي',
            '/[ئ]/u'    => 'ي',
            '/[ؤ]/u'    => 'و',
        ];
        $string = preg_replace(array_keys($entities), array_values($entities), $string);

        // 3. معالجة المسافات
        if ($removeSpaces) {
            // إزالة كل المسافات للمقارنة الصارمة للأسماء المركبة
            $string = preg_replace('/\s+/', '', $string);
        } else {
            // توحيد المسافات فقط
            $string = preg_replace('/\s+/', ' ', $string);
        }

        return trim($string);
    }

    public function finalConfirm(Request $request)
    {
        $excelData = session('excel_data');
        $mapping = $request->input('mapping');

        if (!$excelData || !$mapping) {
            return redirect()->route('import.view')->with('error', 'انتهت صلاحية البيانات، يرجى الرفع مجدداً.');
        }

        DB::beginTransaction();
        try {
            foreach ($excelData as $row) {
                $excelNameInRow = $row[0];

                // البحث: هل تم ربط هذا الاسم من الإكسيل بعميل في السيستم؟
                $match = collect($mapping)->first(function ($item) use ($excelNameInRow) {
                    return isset($item['excel_name']) && $item['excel_name'] == $excelNameInRow;
                });

                if ($match && !empty($match['customer_id'])) {
                    // معالجة التاريخ (كودك السابق الذكي)
                    $dateRaw = $row[1] ?? null;
                    $finalDate = is_numeric($dateRaw)
                        ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateRaw))
                        : Carbon::parse($dateRaw);

                    \App\Models\Account::create([
                        'customer_id' => $match['customer_id'],
                        'debit'       => (float)str_replace(',', '', $row[6] ?? 0),
                        'credit'      => (float)str_replace(',', '', $row[4] ?? 0),
                        'description' => trim($row[2] ?? '') . " (مستورد)",
                        'created_at'  => $finalDate->setTime(10, 0),
                    ]);
                }
            }

            DB::commit();
            session()->forget('excel_data');
            return redirect()
                ->route('import.view', ['group_id' => $request->group_id])
                ->with('success', 'تم استيراد الحركات بنجاح.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
    /**
     * دالة موحدة لتطهير النصوص العربية
     * تقوم بتحويل كل الأشكال الممكنة لحرف واحد لضمان المطابقة
     */
}
