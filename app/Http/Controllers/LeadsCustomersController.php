<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\History;
use App\Models\JobTitle;
use App\Models\LeadsCustomers;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LeadsCustomersController extends Controller
{
    //
    public function index()
    {
        # code...
        $leads = LeadsCustomers::whereIn('status', ['عميل محتمل', 'عميل اساسي'])
            ->whereNotNull('name')
            ->orderByRaw("FIELD(status, 'عميل محتمل', 'عميل اساسي')")
            ->orderByDesc('created_at') // الأحدث أولاً
            ->get();
        $delegates = Delegate::all();
        $jobs = JobTitle::all();
        $groups = CustomerGroup::all();
        $tests = Test::all();
        $governorates = [
            'القاهرة',
            'الجيزة',
            'الأسكندرية',
            'الدقهلية',
            'البحر الأحمر',
            'البحيرة',
            'الفيوم',
            'الغربية',
            'الاسماعيلية',
            'المنوفية',
            'المنيا',
            'القليوبية',
            'الوادي الجديد',
            'السويس',
            'أسوان',
            'أسيوط',
            'بني سويف',
            'بورسعيد',
            'دمياط',
            'الشرقية',
            'ج سيناء',
            'كفر الشيخ',
            'مطروح',
            'الاقصر',
            'قنا',
            'ش سيناء',
            'سوهاج',
            'السعودية',
            'القدس',
            'الأردن',
            'العراق',
            'لبنان',
            'فلسطين',
            'اليمن',
            'عمان',
            'الإمارات العربية المتحدة',
            'الكويت',
            'قطر',
            'البحرين'
        ];
        return view('leads-customers.leads-customers', [
            'leads' => $leads,
            'jobs' => $jobs,
            'delegates' => $delegates,
            "governorates" => $governorates,
            "groups" => $groups,
            "tests" => $tests
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            "card_id" => 'required|unique:leads_customers,card_id',
            "phone" => 'required|unique:leads_customers,phone',
            "phone_two" => 'nullable|unique:leads_customers,phone_two',
        ], [
            'card_id.required' => 'الرقم القومي مطلوب.',
            'card_id.unique' => 'الرقم القومي موجود من قبل.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.unique' => 'رقم الهاتف موجود من قبل.',

            'phone_two.unique' => 'رقم الهاتف الاخر موجود من قبل.',
        ]);
        $lead = $request->all();

        // رفع الصور إذا كانت موجودة
        if ($request->hasFile('image')) {
            $lead['image'] = $request->file('image')->store('uploads', 'public');
        }
        if ($request->hasFile('passport_photo')) {
            $lead['passport_photo'] = $request->file('passport_photo')->store('uploads', 'public');
        }
        if ($request->hasFile('img_national_id_card')) {
            $lead['img_national_id_card'] = $request->file('img_national_id_card')->store('uploads', 'public');
        }
        if ($request->hasFile('img_national_id_card_back')) {
            $lead['img_national_id_card_back'] = $request->file('img_national_id_card_back')->store('uploads', 'public');
        }
        if ($request->hasFile('license_photo')) {
            $lead['license_photo'] = $request->file('license_photo')->store('uploads', 'public');
        }

        $lead['status'] = 'عميل محتمل';
        $lead['customer_id'] = null;
        $lead['evaluation'] = "جارى المعالجة";
        $lead['password'] = Hash::make($lead["phone"]);

        LeadsCustomers::create($lead);

        return redirect()->back();
    }

    public function show($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        return view('leads-customers.leads-customers-show', [
            'lead' => $lead
        ]);
    }

    public function update($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        $delegates = Delegate::all();
        $jobs = JobTitle::all();
        $governorates = [
            'القاهرة',
            'الجيزة',
            'الأسكندرية',
            'الدقهلية',
            'البحر الأحمر',
            'البحيرة',
            'الفيوم',
            'الغربية',
            'الإسماعيلية',
            'المنوفية',
            'المنيا',
            'القليوبية',
            'الوادي الجديد',
            'السويس',
            'أسوان',
            'أسيوط',
            'بني سويف',
            'بورسعيد',
            'دمياط',
            'الشرقية',
            'جنوب سيناء',
            'كفر الشيخ',
            'مطروح',
            'الأقصر',
            'قنا',
            'شمال سيناء',
            'سوهاج'
        ];

        return view('leads-customers.leads-customers-edit', [
            'lead' => $lead,
            'delegates' => $delegates,
            'jobs' => $jobs,
            "governorates" => $governorates,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $lead = LeadsCustomers::findOrFail($id);

        $request->validate([
            "card_id" => 'required|unique:leads_customers,card_id,' . $lead->id,
            "phone" => 'required|unique:leads_customers,phone,' . $lead->id,
            "phone_two" => 'nullable|unique:leads_customers,phone_two,' . $lead->id,
        ], [
            'card_id.required' => 'الرقم القومي مطلوب.',
            'card_id.unique' => 'الرقم القومي موجود من قبل.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.unique' => 'رقم الهاتف موجود من قبل.',
            'phone_two.unique' => 'رقم الهاتف الآخر موجود من قبل.',
        ]);

        // بيانات التحديث الأساسية
        $data = [
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'passport_numder' => $request->input('passport_numder'),
            'age' => $request->input('age'),
            'card_id' => $request->input('card_id'),
            'governorate' => $request->input('governorate'),
            'evaluation' => $request->input('evaluation'),
            'phone' => $request->input('phone'),
            'licence_type' => $request->input('licence_type'),
            'test_type' => $request->input('test_type'),
            'registration_date' => $request->input('registration_date'),
            'job_title_id' => $request->input('job_title_id'),
            'delegate_id' => $request->input('delegate_id'),
            'customer_id' => $lead->customer_id, // الحفاظ على customer_id كما هو
        ];

        // تحديث الصور إذا تم رفعها
        $imageFields = [
            'image',
            'passport_photo',
            'img_national_id_card',
            'img_national_id_card_back',
            'license_photo',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('uploads', 'public');
            }
        }

        // التحديث النهائي
        $lead->update($data);

        return redirect()->back()->with('success', 'تم تحديث البيانات بنجاح');
    }


    public function leadToCustomer(Request $request)
    {
        $request->validate([
            'leads' => "required",
            'group_id' => "required",
        ]);
        $leads = json_decode($request->leads, true);
        if (!is_array($leads)) {
            return response()->json(['error' => 'بيانات العملاء غير صحيحة'], 422);
        }

        foreach ($leads as $leadId) {
            $lead = LeadsCustomers::find($leadId);
            $customer = new Customer();
            $customer->image = $lead->image;
            $customer->name_ar = $lead->name;
            $customer->age = $lead->age;
            $customer->card_id = $lead->card_id;
            $customer->governorate_live = $lead->governorate;
            $customer->phone = $lead->phone;
            $customer->license_type = $lead->licence_type;
            $customer->card_id = $lead->card_id;
            $customer->mrz_image = $lead->passport_photo;
            $customer->job_title_id = $lead->job_title_id;
            $customer->delegate_id = $lead->delegate_id;
            $customer->status = "تجهيز اوراق";
            $customer->customer_group_id = $request->group_id;
            $customer->fcm_token = $lead->fcm_token;
            $customer->save();
            $lead->status = 'عميل اساسي';
            $lead->customer_id = $customer->id;
            $lead->evaluation = 'مقبول';
            $lead->save();
            // إرسال إشعار بعد التحديث
            $title = "تهانينا!";
            $body = "تم تحويلك من عميل محتمل الي عميل اساسي , يمكنك الآن الاستفادة من خدماتنا.";
            $icon = null; // أو رابط أيقونة
            app(ApiAppController::class)->sendFcmMessage("customer", $customer->id, $title, $body, $icon);

            $history = new History();
            $history->description = 'انتقل من عميل محتمل الي عميل اساسي';
            $history->date = Carbon::now();
            $history->customer_id = $customer->id;
            $history->user_id = auth()->id();
            $history->save();

            $img_national_id_card = new DocumentType();
            $img_national_id_card->document_type = "البطاقة الشخصية من الامام";
            $img_national_id_card->status = "لا يوجد بالمكتب";
            $img_national_id_card->file = $lead->img_national_id_card;
            $img_national_id_card->note = 'قادم من عميل محتمل';
            $img_national_id_card->customer_id = $customer->id;
            $img_national_id_card->required = "اجباري";
            $img_national_id_card->save();

            $img_national_id_card_back = new DocumentType();
            $img_national_id_card_back->document_type = "البطاقة الشخصية من الخلف";
            $img_national_id_card_back->status = "لا يوجد بالمكتب";
            $img_national_id_card_back->file = $lead->img_national_id_card_back;
            $img_national_id_card_back->note = 'قادم من عميل محتمل';
            $img_national_id_card_back->customer_id = $customer->id;
            $img_national_id_card_back->required = "اجباري";
            $img_national_id_card_back->save();

            $license_photo = new DocumentType();
            $license_photo->document_type = "صورة اثبات مهنة";
            $license_photo->status = "لا يوجد بالمكتب";
            $license_photo->file = $lead->license_photo;
            $license_photo->note = 'قادم من عميل محتمل';
            $license_photo->customer_id = $customer->id;
            $license_photo->required = "اجباري";
            $license_photo->save();

            $blackList = new BlackList();
            $blackList->block = false;
            $blackList->customer_id = $customer->id;
            $blackList->save();
        }

        return redirect()->route('customer.indes');
    }

    public function search(Request $request)
    {
        $leads = LeadsCustomers::query();

        if ($request->filled('searchBy') && $request->filled('searchInput')) {
            $column = $request->searchBy;
            $value = $request->searchInput;

            if ($column === 'delegate_name') {
                $leads->whereHas('delegate', function ($query) use ($value) {
                    $query->where('name', 'like', "%$value%");
                });
            } elseif ($column === 'registration_date') {
                $leads->whereDate('registration_date', $value); // أو استخدم like لو التاريخ نصي
            } elseif (in_array($column, ['age', 'id'])) {
                $leads->where($column, $value);
            } else {
                $leads->where($column, 'like', "%$value%");
            }
        }

        $leads = $leads->latest()->paginate(20);
        $delegates = Delegate::all();
        $jobs = JobTitle::all();
        $groups = CustomerGroup::all();
        $governorates = [
            'القاهرة',
            'الجيزة',
            'الأسكندرية',
            'الدقهلية',
            'البحر الأحمر',
            'البحيرة',
            'الفيوم',
            'الغربية',
            'الإسماعيلية',
            'المنوفية',
            'المنيا',
            'القليوبية',
            'الوادي الجديد',
            'السويس',
            'أسوان',
            'أسيوط',
            'بني سويف',
            'بورسعيد',
            'دمياط',
            'الشرقية',
            'جنوب سيناء',
            'كفر الشيخ',
            'مطروح',
            'الأقصر',
            'قنا',
            'شمال سيناء',
            'سوهاج'
        ];
        $tests = Test::all();
        return view('leads-customers.leads-customers', [
            'leads' => $leads,
            'jobs' => $jobs,
            'delegates' => $delegates,
            "governorates" => $governorates,
            "groups" => $groups,
            "tests" => $tests,
        ]);
    }

    public function delete($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        $lead->delete();
        return redirect()->back()->with('success', 'تم حذف العميل بنجاح');
    }
}
