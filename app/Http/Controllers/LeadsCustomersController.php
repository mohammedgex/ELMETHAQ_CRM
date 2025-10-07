<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\Evaluation;
use App\Models\History;
use App\Models\JobAnswer;
use App\Models\JobQuestion;
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
        $leads = LeadsCustomers::select([
            'id',
            'name',
            'age',
            'phone',
            'governorate',
            'status',
            'delegate_id',
            'job_title_id',
            'registration_date',
            'image',
            'evaluation'
        ])
            ->whereIn('status', ['عميل محتمل', 'عميل اساسي'])
            ->whereNotNull('name')
            ->orderByRaw("CASE status 
        WHEN 'عميل محتمل' THEN 1 
        WHEN 'عميل اساسي' THEN 2 
        ELSE 3 END")
            ->orderBy('created_at', 'desc')
            ->with([
                'delegate:id,name',
                'jobTitle:id,title'
            ])
            ->paginate(20);

        $delegates = Delegate::select('id', 'name')->get();
        $jobs = JobTitle::select('id', 'title')->get();
        $groups = CustomerGroup::select('id', 'title')->get();
        $tests = Test::select('id', 'title')->get();
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

        $lead = LeadsCustomers::create($lead);
        $history = new History();
        $history->description = "تم اضافة عميل محتمل جديد";
        $history->date = Carbon::now();
        $history->lead_id = $lead->id;
        $history->user_id = auth()->id();
        $history->save();
        if ($request->has('questions')) {
            foreach ($request->questions as $questionId => $answer) {

                // لو checkbox ممكن يجي Array
                if (is_array($answer)) {
                    $answer = implode(',', $answer);
                }

                JobAnswer::create([
                    'job_question_id' => $questionId,
                    'lead_id' => $lead->id,
                    'answer' => $answer,
                ]);
            }
        }
        $phoneDelegate = preg_replace('/\D/', '', $lead->delegate->phone); // إزالة كل ما ليس رقم

        if ($request->delegate_id && $lead->delegate && $lead->delegate->phone && strlen($phoneDelegate) == 11) {
            app(ApiAppController::class)->sendSms($lead->delegate->phone, "تم تسجيل العميل: " . $lead['name']);
        }

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

    public function update($id, $error = null)
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
        $questions = JobQuestion::where('job_title_id', $lead->job_title_id)->get();

        $history = $lead->historis()->where("description", "تم اضافة عميل محتمل جديد")->with('user')->latest()->first();

        return view('leads-customers.leads-customers-edit', [
            'lead' => $lead,
            'delegates' => $delegates,
            'jobs' => $jobs,
            "governorates" => $governorates,
            'error' => $error, // مررها للواجهة
            'questions' => $questions,
            "history" => $history
        ]);
    }

    public function edit(Request $request, $id)
    {
        $lead = LeadsCustomers::findOrFail($id);
        // تحقق يدوي من الرقم القومي قبل الفاليديشن
        $existingLead = LeadsCustomers::where('card_id', $request->card_id)
            ->where('id', '!=', $lead->id)
            ->first();

        if ($existingLead) {
            // استدعاء فنكشن اخرى او تعمل redirect
            return $this->update($existingLead->id, "الرقم القومي موجود من قبل وسيتم تحويلك علي العميل صاحب الرقم القومي");
        }

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
            'phone' => $request->input('phone'),
            'licence_type' => $request->input('licence_type'),
            'test_type' => $request->input('test_type'),
            'registration_date' => $request->input('registration_date'),
            'job_title_id' => $request->input('job_title_id'),
            'delegate_id' => $request->input('delegate_id'),
            "notes" => $request->input('notes'),
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
        if ($request->phone && $request->phone !== $lead->phone) {
            $lead->password = Hash::make($request->phone);
            $lead->save();
        }
        // ✅ لو اتغيرت الوظيفة -> امسح الإجابات القديمة
        if ($lead->wasChanged('job_title_id')) {
            $lead->answers()->delete();
        }

        // ✅ حفظ/تحديث الإجابات
        if ($request->has('questions')) {
            foreach ($request->questions as $questionId => $answer) {
                if (is_array($answer)) {
                    $answer = implode(',', $answer);
                }

                // ⛔ لو الإجابة فاضية سيبها
                if ($answer === null || $answer === '' || trim($answer) === '') {
                    continue;
                }

                $lead->answers()->updateOrCreate(
                    ['job_question_id' => $questionId],
                    ['answer' => $answer]
                );
            }
        }

        $history = new History();
        $history->description = "تم تعديل بيانات عميل محتمل";
        $history->date = Carbon::now();
        $history->lead_id = $lead->id;
        $history->user_id = auth()->id();
        $history->save();

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
            'سوهاج',
            // مضافة
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
            'البحرين',
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
        if ($lead->customer_id) {
            # code...
            return redirect()->back()->with('error', 'لا يمكن حذف هذا العميل لأنه مرتبط بعميل أساسي');
        }
        $lead->delete();
        return redirect()->back()->with('success', 'تم حذف العميل بنجاح');
    }

    public function resetPassword($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        if ($lead->phone) {
            # code...
            $lead->password =  Hash::make($lead->phone);
            $lead->save();
        }
        return redirect()->back()->with("success", "تم تغيير الباسورد ليكون رقم الهاتف");
    }

    // فشل في تسجيل الدخول
    public function loginFail()
    {
        # code...
        $leads = LeadsCustomers::query()
            ->whereNull('img_national_id_card')
            ->whereNull('img_national_id_card_back')
            ->whereNull('passport_numder')
            ->whereNull('card_id')
            ->orderByDesc('created_at') // الأحدث أولاً
            ->get();

        return view("leads-customers.loginFail", [
            'leads' => $leads
        ]);
    }

    public function checkPhone(Request $request)
    {
        $customer = LeadsCustomers::where('phone', $request->phone)->first();

        return response()->json([
            'exists' => $customer ? true : false,
            'id'     => $customer ? $customer->id : null,
            'name'   => $customer ? $customer->name : null,
        ]);
    }

    public function checkCard(Request $request)
    {
        $customer = LeadsCustomers::where('card_id', $request->card_id)->first();

        return response()->json([
            'exists' => $customer ? true : false,
            'id'     => $customer ? $customer->id : null,
            'name'   => $customer ? $customer->name : null,
        ]);
    }


    public function CV($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        $company = CompanySetting::first();

        return view('reports.CV.CV', [
            'leads' => [$lead],
            'company' => $company,
        ]);
    }
    public function bulkCv(Request $request)
    {
        $leadIds = $request->input('lead_ids', []);

        // إذا كانت string (مثلاً "1,2,3")، حولها لمصفوفة
        if (is_string($leadIds)) {
            $leadIds = explode(',', $leadIds);
        }

        if (count($leadIds) === 0) {
            return back()->with('error', 'من فضلك اختر عميل واحد على الأقل');
        }

        $leads   = LeadsCustomers::whereIn('id', $leadIds)->get();
        $company = CompanySetting::first();
        return view('reports.CV.CV', [
            'leads' => $leads,
            'company' => $company,
        ]);
    }

    public function showSignIn()
    {
        # code...
        $delegates = Delegate::select('id', 'name')->get();
        $jobs = JobTitle::select('id', 'title')->where("show_in_app", "yes")->get();
        $groups = CustomerGroup::select('id', 'title')->get();
        $tests = Test::select('id', 'title')->get();
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
        return view('leads-customers.sign-lead', [
            'jobs' => $jobs,
            'delegates' => $delegates,
            "governorates" => $governorates,
            "groups" => $groups,
            "tests" => $tests
        ]);
    }
    public function createLead(Request $request)
    {
        $request->validate([
            "card_id" => 'required|unique:leads_customers,card_id',
            "phone" => 'required|unique:leads_customers,phone',
            "phone_two" => 'nullable|unique:leads_customers,phone_two',
            "img_national_id_card" => 'required|image|mimes:jpeg,png,jpg,gif',
            "img_national_id_card_back" => 'required|image|mimes:jpeg,png,jpg,gif',
        ], [
            'card_id.required' => 'الرقم القومي مطلوب.',
            'card_id.unique' => 'الرقم القومي موجود من قبل.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.unique' => 'رقم الهاتف موجود من قبل.',

            'phone_two.unique' => 'رقم الهاتف الاخر موجود من قبل.',

            'img_national_id_card.required' => 'صورة البطاقة الامامية مطلوبة.',
            'img_national_id_card.image' => 'صورة البطاقة الامامية يجب ان تكون صورة.',
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

        $lead['test_type'] = "اول اختبار";
        $lead['registration_date'] = now()->toDateString();
        $lead['status'] = 'عميل محتمل';
        $lead['customer_id'] = null;
        $lead['evaluation'] = "جارى المعالجة";
        $lead['password'] = Hash::make($lead["phone"]);

        $lead = LeadsCustomers::create($lead);
        if ($request->has('questions')) {
            foreach ($request->questions as $questionId => $answer) {

                // لو checkbox ممكن يجي Array
                if (is_array($answer)) {
                    $answer = implode(',', $answer);
                }

                JobAnswer::create([
                    'job_question_id' => $questionId,
                    'lead_id' => $lead->id,
                    'answer' => $answer,
                ]);
            }
        }

        return redirect()->back()->with('success', "تم تسجيل بياناتك بنجاح وسيتم التواصل معك قريبا");
    }
    public function signLeadinTest($id)
    {
        # code...
        $delegates = Delegate::select('id', 'name')->get();
        $jobs = JobTitle::select('id', 'title')->where("show_in_app", "yes")->get();
        $groups = CustomerGroup::select('id', 'title')->get();
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
        return view('tests.sign-in-test', [
            'jobs' => $jobs,
            'delegates' => $delegates,
            "governorates" => $governorates,
            "groups" => $groups,
            "test_id" => $id
        ]);
    }
    public function createLeadToTest(Request $request)
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
        if ($request->hasFile('img_national_id_card')) {
            $lead['img_national_id_card'] = $request->file('img_national_id_card')->store('uploads', 'public');
        }
        if ($request->hasFile('img_national_id_card_back')) {
            $lead['img_national_id_card_back'] = $request->file('img_national_id_card_back')->store('uploads', 'public');
        }
        if ($request->hasFile('license_photo')) {
            $lead['license_photo'] = $request->file('license_photo')->store('uploads', 'public');
        }

        $lead['test_type'] = "اول اختبار";
        $lead['registration_date'] = now()->toDateString();
        $lead['status'] = 'عميل محتمل';
        $lead['customer_id'] = null;
        $lead['evaluation'] = "جارى المعالجة";
        $lead['password'] = Hash::make($lead["phone"]);

        $lead = LeadsCustomers::create($lead);
        // #############################################3
        $test = Test::find($request->test_id);
        $test->leads()->syncWithoutDetaching($lead->id);

        // تحقق من وجود تقييم سابق لنفس العميل والاختبار
        $alreadyExists = Evaluation::where('lead_id', $lead->id)
            ->where('test_id', $test->id)
            ->exists();

        if (!$alreadyExists) {
            $lastCode = Evaluation::where('test_id', $test->id)
                ->selectRaw('MAX(CAST(code AS UNSIGNED)) as max_code')
                ->value('max_code');
            $nextCode = $lastCode ? $lastCode + 1 : 1;

            Evaluation::create([
                'lead_id' => $lead->id,
                'test_id' => $test->id,
                'code'    => $nextCode,
            ]);
        }

        // #############################################3
        if ($request->has('questions')) {
            foreach ($request->questions as $questionId => $answer) {

                // لو checkbox ممكن يجي Array
                if (is_array($answer)) {
                    $answer = implode(',', $answer);
                }

                JobAnswer::create([
                    'job_question_id' => $questionId,
                    'lead_id' => $lead->id,
                    'answer' => $answer,
                ]);
            }
        }
        $phoneDelegate = preg_replace('/\D/', '', $lead->delegate->phone); // إزالة كل ما ليس رقم

        if ($request->delegate_id && $lead->delegate && $lead->delegate->phone && strlen($phoneDelegate) == 11) {
            app(ApiAppController::class)->sendSms($lead->delegate->phone, "تم تسجيل العميل: " . $lead['name']);
        }

        $history = new History();
        $history->description = "تم اضافة عميل محتمل الي اختبار " . $test->title;
        $history->date = Carbon::now();
        $history->lead_id = $lead->id;
        $history->user_id = auth()->id();
        $history->save();

        return app(ReportsController::class)->test_card($lead->id, $request->test_id);
    }
}
