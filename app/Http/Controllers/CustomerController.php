<?php

namespace App\Http\Controllers;

use App\Models\bag;
use App\Models\BlackList;
use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\Embassy;
use Illuminate\Support\Facades\Hash;
use App\Models\Evaluation;
use App\Models\FileTitle;
use App\Models\History;
use App\Models\JobTitle;
use App\Models\LeadsCustomers;
use App\Models\Payments;
use App\Models\PaymentTitle;
use App\Models\Sponser;
use App\Models\User;
use App\Models\VisaType;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    //
    public function add($id = null)
    {
        $delegates = Delegate::latest()->get();
        $evalutions = Evaluation::latest()->get();
        $groups = CustomerGroup::latest()->get();
        $jobs = JobTitle::latest()->get();
        $sponsers = Sponser::latest()->get();
        $paymentTitles = PaymentTitle::latest()->get();
        $visas = VisaType::latest()->get();

        // foreach ($visas as $visa) {
        //     $visasCount = $visa->visa_professions()->sum('profession_count');

        //     if (intval($visasCount) < intval($visa->count)) {
        //         $validVisas[] = $visa;
        //     }
        // }

        $customer = [];
        if ($id == null) {
            $files = [];
            $payments = [];
            $histories = [];
            $fileTitles = FileTitle::all(); // لو مفيش عميل هات كل العناوين عادي
        } else {
            $customer = Customer::find($id);
            $files = $customer->documentTypes;
            $payments = $customer->payments;
            $histories = $customer->histories()->orderBy('created_at', 'desc')->get();

            // 🛠 استبعاد العناوين اللي العميل استعملها
            $usedDocumentTypes = $customer->documentTypes->pluck('document_type')->toArray();

            $fileTitles = FileTitle::whereNotIn('title', $usedDocumentTypes)->get();
        }

        return view('customers.customer-create', [
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
            'fileTitles' => $fileTitles,
            'paymentTitles' => $paymentTitles,
            'histories' => $histories,
            'files' => $files,
            'payments' => $payments,
            'edit' => $customer
        ]);
    }

    public function index()
    {
        $delegates = Delegate::latest()->get();
        $evalutions = Evaluation::latest()->get();
        $groups = CustomerGroup::latest()->get();
        $jobs = JobTitle::latest()->get();
        $sponsers = Sponser::latest()->get();
        $visas = VisaType::latest()->get();
        $company = CompanySetting::first();
        $customers = Customer::with([
            'sponser',
            'visaType.embassy',
            'customerGroup.visaProfession',
            'customerGroup.visaType.embassy',
            'customerGroup.visaType.sponser',
            'delegate',
            'evaluation',
            'jobTitle',
        ])->latest()->paginate(30);

        return view("customers.customer", [
            'customers' => $customers,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
            "company" => $company
        ]);
    }

    public function basicDetails(Request $request)
    {
        $request->validate([
            'card_id' => 'required|unique:customers,card_id',
            'name_ar' => "required",
            'phone' => "required",
        ]);

        $all = $request->all();

        // لو فيه صورة، ضيفها إلى الـ array
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('uploads', 'public');
            $all['image'] = $filePath;
        }

        // إنشاء العميل بكل البيانات دفعة واحدة
        $customer = Customer::create($all);

        // إضافة للسجل الأسود (block = false)
        $blackList = new BlackList();
        $blackList->block = false;
        $blackList->customer_id = $customer->id;
        $blackList->save();

        return redirect()->route("customer.add", $customer->id)->with('tap', 'info');
    }

    public function editBasicDetails(Request $request, $id)
    {
        $request->validate([
            'card_id' => 'required|unique:customers,card_id,' . $id,
        ]);
        $customer = Customer::find($id);

        $data = $request->all();

        // لو فيه صورة
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('uploads', 'public');
            $data['image'] = $filePath;
        }
        // عند تحديث رقم الهاتف
        if ($request->filled('phone')) {
            if ($customer->LeadCustomer) {
                # code...
                $customer->LeadCustomer->phone = $request->phone;
                $customer->LeadCustomer->save();
            }
        }
        if ($request->filled('delegate_id')) {
            if ($customer->LeadCustomer) {
                # code...
                $customer->LeadCustomer->delegate_id = $request->delegate_id;
                $customer->LeadCustomer->save();
            }
        }
        if ($request->filled('job_title_id')) {
            if ($customer->LeadCustomer) {
                # code...
                $customer->LeadCustomer->job_title_id = $request->job_title_id;
                $customer->LeadCustomer->save();
            }
        }


        // تحديث البيانات كلها
        $customer->update($data);
        if ($request->filled('payment_title_id')) {
            $customer->paymentTitles()->sync($request->payment_title_id);
            if ($customer->LeadCustomer) {
                $customer->LeadCustomer->paymentTitles()->sync($request->payment_title_id);
            }
        }
        return redirect()->route("customer.add", $customer->id)->with('tap', 'info');
    }

    public function mrz(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // التاريخ: تاريخ الميلاد
        if ($request->filled('date_birth')) {
            $customer->date_birth = Carbon::createFromFormat('d/m/Y', $request->date_birth)->format('Y-m-d');
        }

        // التاريخ: انتهاء الجواز
        if ($request->filled('passport_expire_date')) {
            $customer->passport_expire_date = Carbon::createFromFormat('d/m/Y', $request->passport_expire_date)->format('Y-m-d');
        }
        if ($request->filled('passport_issuance_date')) {
            $customer->passport_issuance_date = Carbon::createFromFormat('d/m/Y', $request->passport_issuance_date)->format('Y-m-d');
        }

        if ($request->filled('mrz')) {
            $customer->mrz = $request->mrz;
        }

        if ($request->hasFile('mrz_image')) {
            $filePath = $request->file('mrz_image')->store('uploads', 'public');
            $customer->mrz_image = $filePath;
        }

        if ($request->filled('passport_id')) {
            $customer->passport_id = $request->passport_id;
        }

        if ($request->filled('nationality')) {
            $customer->nationality = $request->nationality;
        }

        if ($request->filled('gender')) {
            $customer->gender = $request->gender;
        }

        if ($request->filled('age')) {
            $customer->age = $request->age;
        }

        if ($request->filled('issue_place')) {
            $customer->issue_place = $request->issue_place;
        }
        // if ($request->filled('card_id')) {
        //     $customer->card_id = $request->card_id;
        // }

        if ($request->filled('name_en_mrz')) {
            $customer->name_en_mrz = $request->name_en_mrz;
        }
        // if ($request->filled('name_ar')) {
        //     $customer->name_ar = $request->name_ar;
        // }
        $customer->save();

        return redirect()->route("customer.add", $customer->id)->with('tap', 'mrz');
    }

    public function attachments(Request $request, $id)
    {
        $customer = Customer::find($id);

        // التحقق مما إذا كان العميل موجودًا
        if (!$customer) {
            return redirect()->back()->with('error', 'العميل غير موجود.');
        }

        $document = new DocumentType();

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $document->file = $filePath;
        } else {
            // إرسال إشعار بعد التحديث
            $title = "مستند اجبارى!";
            $body = "يرجى العلم بأنه تم إرفاق مستند إجباري من نوع: {$request->document_type}. نرجو مراجعة التطبيق في أقرب وقت.";
            $icon = null; // أو رابط أيقونة
            app(ApiAppController::class)->sendFcmMessage("customer", $customer->id, $title, $body, $icon);
        }

        $document->document_type = $request->document_type;
        $document->status = $request->status;
        $document->note = $request->note;
        $document->customer_id = $customer->id;
        $document->required = $request->required;
        $document->save();

        return redirect()->route("customer.add", $customer->id)->with('tap', 'attach');
    }
    public function payments(Request $request, $id)
    {
        $customer = Customer::find($id);
        $payment = new Payments();
        $payment->amount = $request->amount;
        $payment->amoun_rest = $request->amoun_rest;
        $payment->payment_title_id = $request->payment_title_id;
        $payment->customer_id = $customer->id;

        $payment->save();

        return redirect()->route("customer.add", $customer->id)->with('tap', 'payment');
    }

    public function history(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'لم يتم العثور على العميل.');
        }

        $history = new History();
        $history->description = $request->description;

        // تأكد من صحة تنسيق التاريخ
        try {
            $history->date = Carbon::createFromFormat('Y-m-d\TH:i', $request->date)
                ->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'تنسيق التاريخ غير صحيح.');
        }

        $history->customer_id = $customer->id;
        $history->user_id = auth()->user()->id;
        $history->save();

        return redirect()->route("customer.add", $customer->id)->with('tap', 'history');
    }

    public function show($id)
    {
        # code...
        $customer = Customer::find($id);
        return view('customers.customer-show', [
            'customer' => $customer
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'searchBy' => 'required',
            'searchInput' => 'required'
        ]);
        $searchBy = $request->input('searchBy');
        $searchInput = $request->input('searchInput');

        // البحث في جدول العملاء
        $customers = Customer::where($searchBy, 'LIKE', "%$searchInput%")->paginate(30);

        $company = CompanySetting::first();
        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        return view("customers.customer", [
            'customers' => $customers,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
            "company" => $company
        ]);
    }
    public function searchConsulate(Request $request)
    {
        $request->validate([
            'searchBy' => 'required',
            'searchInput' => 'required'
        ]);


        $searchBy = $request->input('searchBy');
        $searchInput = $request->input('searchInput');

        // البحث في جدول العملاء
        $conditions = [
            'medical_examination' => 'لائق',
            'virus_examination' => 'سالب',
            'finger_print_examination' => 'تم تصدير الاكسيل',
            'engaz_request' => 'تم الحجز'
        ];

        $customers = Customer::where($searchBy, 'LIKE', "%$searchInput%")
            ->where($conditions)
            ->get();


        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        return view("customers.customer", [
            'customers' => $customers,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
        ]);
    }

    public function filter(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('mrz')) {
            $query->where('mrz', 'like', '%' . $request->mrz . '%');
        }

        if ($request->filled('name_ar')) {
            $query->where('name_ar', 'like', '%' . $request->name_ar . '%');
        }

        if ($request->filled('card_id')) {
            $query->where('card_id', 'like', '%' . $request->card_id . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('governorate_live')) {
            $query->where('governorate_live', $request->governorate_live);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('license_type')) {
            $query->where('license_type', $request->license_type);
        }

        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        if ($request->filled('passport_id')) {
            $query->where('passport_id', 'like', '%' . $request->passport_id . '%');
        }

        if ($request->filled('visa_type_id')) {
            $query->where('visa_type_id', $request->visa_type_id);
        }

        if ($request->filled('sponser_id')) {
            $query->where('sponser_id', $request->sponser_id);
        }

        if ($request->filled('customer_group_id')) {
            $query->where('customer_group_id', $request->customer_group_id);
        }

        if ($request->filled('job_title_id')) {
            $query->where('job_title_id', $request->job_title_id);
        }

        if ($request->filled('delegate_id')) {
            $query->where('delegate_id', $request->delegate_id);
        }

        if ($request->filled('education')) {
            $query->where('education', $request->education);
        }

        if ($request->filled('marital_status')) {
            $query->where('marital_status', $request->marital_status);
        }

        if ($request->filled('medical_examination')) {
            $query->where('medical_examination', $request->medical_examination);
        }

        if ($request->filled('finger_print_examination')) {
            $query->where('finger_print_examination', $request->finger_print_examination);
        }

        if ($request->filled('virus_examination')) {
            $query->where('virus_examination', $request->virus_examination);
        }

        if ($request->filled('engaz_request')) {
            $query->where('engaz_request', $request->engaz_request);
        }

        $customers = $query->get();

        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        $company = CompanySetting::first();

        return view("customers.customer", [
            'fillter' => $request->all(),
            'customers' => $customers,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
            "company" => $company
        ]);
    }
    public function filterGroupAndBag(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('customer_group_id')) {
            $query->where('customer_group_id', $request->customer_group_id);
        }

        if ($request->filled('bag_id')) {
            $query->where('bag_id', $request->bag_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('marital_status')) {
            $query->where('marital_status', $request->marital_status);
        }

        if ($request->filled('medical_examination')) {
            $query->where('medical_examination', $request->medical_examination);
        }

        if ($request->filled('finger_print_examination')) {
            $query->where('finger_print_examination', $request->finger_print_examination);
        }

        if ($request->filled('virus_examination')) {
            $query->where('virus_examination', $request->virus_examination);
        }

        if ($request->filled('engaz_request')) {
            $query->where('engaz_request', $request->engaz_request);
        }

        $customers = $query->get();

        $all = Customer::all();

        if ($request->filled('bag_id')) {
            $bag = bag::find($request->bag_id);
            return view("group-customers", [
                'fillter' => $request->all(),
                'customers' => $customers,
                "bag" => $bag,
                "all" => $all
            ]);
        } elseif ($request->filled('customer_group_id')) {
            $group = CustomerGroup::find($request->customer_group_id);

            return view("group-customers", [
                'fillter' => $request->all(),
                'customers' => $customers,
                'group' => $group,
                "all" => $all
            ]);
        }


        return view("group-customers", [
            'fillter' => $request->all(),
            'customers' => $customers,
        ]);
    }

    public function filterConsulate(Request $request)
    {
        $query = Customer::query();

        $query->where(['medical_examination' => 'لائق', 'virus_examination' => 'سالب', 'finger_print_examination' => 'تم تصدير الاكسيل', 'engaz_request' => 'تم الحجز']);


        if ($request->filled('mrz')) {
            $query->where('mrz', 'like', '%' . $request->mrz . '%');
        }

        if ($request->filled('name_ar')) {
            $query->where('name_ar', 'like', '%' . $request->name_ar . '%');
        }

        if ($request->filled('card_id')) {
            $query->where('card_id', 'like', '%' . $request->card_id . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('governorate')) {
            $query->where('governorate', $request->governorate);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('license_type')) {
            $query->where('license_type', $request->license_type);
        }

        if ($request->filled('age')) {
            $query->where('age', $request->age);
        }

        if ($request->filled('passport_id')) {
            $query->where('passport_id', 'like', '%' . $request->passport_id . '%');
        }

        if ($request->filled(key: 'visa_type_id')) {
            $query->where('visa_type_id', $request->visa_type_id);
        }

        if ($request->filled('sponser_id')) {
            $query->where('sponser_id', $request->sponser_id);
        }

        if ($request->filled('customer_group_id')) {
            $query->where('customer_group_id', $request->customer_group_id);
        }

        if ($request->filled('job_title_id')) {
            $query->where('job_title_id', $request->job_title_id);
        }

        if ($request->filled('delegate_id')) {
            $query->where('delegate_id', $request->delegate_id);
        }

        if ($request->filled('education')) {
            $query->where('education', $request->education);
        }

        if ($request->filled('marital_status')) {
            $query->where('marital_status', $request->marital_status);
        }

        if ($request->filled('medical_examination')) {
            $query->where('medical_examination', $request->medical_examination);
        }

        if ($request->filled('finger_print_examination')) {
            $query->where('finger_print_examination', $request->finger_print_examination);
        }

        if ($request->filled('virus_examination')) {
            $query->where('virus_examination', $request->virus_examination);
        }

        if ($request->filled('engaz_request')) {
            $query->where('engaz_request', $request->engaz_request);
        }

        $customers = $query->get();

        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();

        return view("customers.customer", [
            'fillter' => $request->all(),
            'customers' => $customers,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
        ]);
    }

    public function consulate()
    {
        # code...
        $Consulate = Customer::where(['medical_examination' => 'لائق', 'virus_examination' => 'سالب', 'finger_print_examination' => 'تم تصدير الاكسيل', 'engaz_request' => 'تم الحجز'])->get();
        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();

        return view("customers.customer", [
            'customers' => $Consulate,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
        ]);
    }

    public function printAttachments($clientId)
    {
        $client = Customer::with(relations: 'documentTypes')->findOrFail(id: $clientId);
        return view('print-customer.cutomer-documents', compact('client'));
    }

    public function printPayments($clientId)
    {
        $client = Customer::with(relations: 'payments')->findOrFail(id: $clientId);
        return view('print-customer.customer-payments', compact('client'));
    }

    public function customerGroup($group_id)
    {
        # code...
        $group = CustomerGroup::find($group_id);
        if (!$group) {
            # code...
            return response()->json([
                'error' => 'group not found'
            ]);
        }

        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        $company = CompanySetting::first();
        $customers = Customer::with([
            'visaType',
            'sponser',
            'visaType.embassy',              // مثال علاقة فرعية داخل visaType
            'customerGroup.visaType',
            'customerGroup.visaProfession',
            'customerGroup.visaType.embassy',        // لو موجودة في CustomerGroup
            'customerGroup.visaType.sponser',        // لو موجودة في CustomerGroup
            'delegate',
            'evaluation',
            'jobTitle',
        ])->where('customer_group_id', $group_id)->paginate(50);
        return view('group.customers-group', [
            'customers' => $customers,
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas,
            "company" => $company,
            "group" => $group
        ]);
    }
    public function addToGroup(Request $request, $group_id)
    {
        $customer = Customer::find($request->customer_id);
        $customer->customer_group_id = $group_id;
        $customer->save();
        return redirect()->route('group.customer', $group_id);
    }

    public function hospitalBook($customer_id)
    {
        $customer = Customer::find($customer_id);
        $customer->medical_examination = "تم الحجز";
        $customer->save();
        return response()->json([
            'success' => 'done'
        ]);
    }

    public function engaz_request(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $customer->e_visa_number = "E" . $request->e_number;
        $customer->engaz_request = "تم الحجز";
        $customer->save();

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $history = new History();
        $history->description = "تم حجز انجاز";
        $history->date = now();

        $history->customer_id = $customer->id;
        $history->user_id = $user->id;
        $history->save();

        return response()->json([
            'success' => 'done'
        ]);
    }

    public function archive($id)
    {
        $customer = Customer::findOrFail($id);
        // أرشفة العميل
        $customer->update([
            'archived_at' => now(),
        ]);
        $customer->customer_group_id = null; // إلغاء ربط العميل بأي مجموعة
        $customer->save();
        // إضافة سجل في التاريخ
        $history = new History();
        $history->description = "تم أرشفة العميل";
        $history->date = now();
        $history->customer_id = $customer->id;
        $history->user_id = auth()->user()->id; // أو أي مستخدم آخر
        $history->save();
        return redirect()->back()->with('success', 'تم أرشفة العميل بنجاح.');
    }

    public function unarchive($id)
    {
        $customer = Customer::findOrFail($id);
        // فك الأرشفة
        $customer->update([
            'archived_at' => null,
        ]);
        // إضافة سجل في التاريخ
        $history = new History();
        $history->description = "تم استرجاع العميل من الأرشيف";
        $history->date = now();
        $history->customer_id = $customer->id;
        $history->user_id = auth()->user()->id; // أو أي مستخدم آخر
        $history->save();
        return redirect()->back()->with('success', 'تم استرجاع العميل بنجاح.');
    }

    public function archived()
    {
        $customers = Customer::archived()->get(); // باستخدام الـ scope اللي عملناه
        return view('customers.archived', compact('customers'));
    }


    public function fillterdeep()
    {
        $delegates = Delegate::all();
        $sponsors  = Sponser::all();
        $consulates = Embassy::all();
        $packages = bag::all();
        $jobs = JobTitle::all();

        return view('deepFilter.deep-filter', compact('delegates', 'sponsors', 'consulates', "packages", "jobs"));
    }

    public function getVisas(Request $request)
    {
        try {
            // التحقق من وجود معاملات البحث
            $sponsorIds = $request->sponsor_ids ?? [];
            $consulateIds = $request->consulate_ids ?? [];

            // التأكد من أن المعاملات arrays
            if (!is_array($sponsorIds)) {
                $sponsorIds = [$sponsorIds];
            }
            if (!is_array($consulateIds)) {
                $consulateIds = [$consulateIds];
            }

            // بناء الاستعلام
            $query = VisaType::query();

            // فلترة حسب الكفلاء
            if (!empty($sponsorIds)) {
                $sponsorIds = array_filter($sponsorIds); // إزالة القيم الفارغة
                if (!empty($sponsorIds)) {
                    $query->whereIn('sponser_id', $sponsorIds); // تأكد من اسم العمود
                }
            }

            // فلترة حسب القنصليات/السفارات
            if (!empty($consulateIds)) {
                $consulateIds = array_filter($consulateIds); // إزالة القيم الفارغة
                if (!empty($consulateIds)) {
                    $query->whereIn('embassy_id', $consulateIds);
                }
            }

            // جلب البيانات
            $visaTypes = $query->select('id', 'name')
                ->orderBy('name') // ترتيب أبجدي
                ->get();

            // تسجيل للتشخيص (يمكن إزالته في الإنتاج)
            \Log::info('Visa Types Query', [
                'sponsor_ids' => $sponsorIds,
                'consulate_ids' => $consulateIds,
                'count' => $visaTypes->count(),
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            // إرجاع الاستجابة
            return response()->json($visaTypes, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            // تسجيل الخطأ
            \Log::error('Error in getVisas method', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'request_data' => $request->all()
            ]);

            // إرجاع استجابة خطأ
            return response()->json([
                'error' => 'حدث خطأ في جلب التأشيرات',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    // إضافة دالة مساعدة للتحقق من صحة البيانات (اختيارية)
    private function validateVisaRequest(Request $request)
    {
        return $request->validate([
            'sponsor_ids' => 'nullable|array',
            'sponsor_ids.*' => 'integer|exists:sponsors,id',
            'consulate_ids' => 'nullable|array',
            'consulate_ids.*' => 'integer|exists:consulates,id',
        ], [
            'sponsor_ids.*.exists' => 'أحد الكفلاء المحددين غير موجود',
            'consulate_ids.*.exists' => 'إحدى القنصليات المحددة غير موجودة'
        ]);
    }
    // إضافة هذه الدالة في Controller المناسب (مثل VisaController أو GroupController)

    public function getGroupsByVisas(Request $request)
    {
        try {
            // التحقق من وجود معاملات البحث
            $visaIds = $request->visa_ids ?? [];

            // التأكد من أن المعاملات arrays
            if (!is_array($visaIds)) {
                $visaIds = [$visaIds];
            }

            // فلترة القيم الفارغة
            $visaIds = array_filter($visaIds);

            if (empty($visaIds)) {
                return response()->json([], 200);
            }

            // جلب المجموعات المرتبطة بالتأشيرات
            // اختر إحدى الطرق التالية حسب هيكل قاعدة البيانات:

            // الطريقة 1: إذا كانت المجموعات مرتبطة مباشرة بالتأشيرات
            $groups = CustomerGroup::whereHas('visaType', function ($query) use ($visaIds) {
                $query->whereIn('visa_types.id', $visaIds);
            })
                ->select('id', 'title as name') // تعديل هنا
                ->distinct()
                ->orderBy('title')
                ->get();

            // الطريقة 2: إذا كانت العلاقة من خلال جدول وسطي
            /*
        $groups = Group::join('group_visa_type', 'groups.id', '=', 'group_visa_type.group_id')
                      ->whereIn('group_visa_type.visa_type_id', $visaIds)
                      ->select('groups.id', 'groups.name')
                      ->distinct()
                      ->orderBy('groups.name')
                      ->get();
        */

            // الطريقة 3: إذا كان group_id موجود في جدول visa_types
            /*
        $groupIds = VisaType::whereIn('id', $visaIds)
                           ->whereNotNull('group_id')
                           ->pluck('group_id')
                           ->unique();
                           
        $groups = Group::whereIn('id', $groupIds)
                      ->select('id', 'name')
                      ->orderBy('name')
                      ->get();
        */

            // تسجيل للتشخيص
            \Log::info('Groups by Visas Query', [
                'visa_ids' => $visaIds,
                'groups_count' => $groups->count()
            ]);

            // إرجاع الاستجابة
            return response()->json($groups, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            // تسجيل الخطأ
            \Log::error('Error in getGroupsByVisas method', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'request_data' => $request->all()
            ]);

            // إرجاع استجابة خطأ
            return response()->json([
                'error' => 'حدث خطأ في جلب المجموعات',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    public function filterCustomers(Request $request)
    {
        $query = Customer::query();
        if ($request->filled('package_ids') && is_array($request->package_ids)) {
            $query->whereIn('bag_id', $request->package_ids);
        }

        if ($request->filled('governorates') && is_array($request->governorates)) {
            $query->whereIn('governorate', $request->governorates);
        }

        if ($request->filled('job_title_ids') && is_array($request->job_title_ids)) {
            $query->whereIn('job_title_id', $request->job_title_ids);
        }

        if ($request->filled('sponsor_ids') && is_array($request->sponsor_ids)) {
            $query->whereHas('customerGroup.visaType.sponser', function ($q) use ($request) {
                $q->whereIn('id', $request->sponsor_ids);
            });
        }
        if ($request->filled('consulate_ids') && is_array($request->consulate_ids)) {
            $query->whereHas('customerGroup.visaType', function ($q) use ($request) {
                $q->whereIn('embassy_id', $request->consulate_ids);
            });
        }

        if ($request->filled('visa_ids') && is_array($request->visa_ids)) {
            $query->whereHas('customerGroup', function ($q) use ($request) {
                $q->whereIn('visa_type_id', $request->visa_ids);
            });
        }

        if ($request->filled('group_ids') && is_array($request->group_ids)) {
            $query->whereIn('customer_group_id', $request->group_ids);
        }

        if ($request->filled('delegates') && is_array($request->delegates)) {
            $query->whereIn('delegate_id', $request->delegates);
        }

        $customers = $query->with(['bag', 'jobTitle', 'sponser', 'embassy', 'visaType', 'customerGroup'])->get();
        $delegates = Delegate::all();
        $sponsors  = Sponser::all();
        $consulates = Embassy::all();
        $packages = bag::all();
        $jobs = JobTitle::all();

        // dd($customers->count());
        return view('deepFilter.deep-filter', compact('customers', "delegates", "sponsors", "consulates", "packages", "jobs"));
    }

    public function deepSearch()
    {
        # code...

        return view('deep-search');
    }

    public function deepSearchFN(Request $request)
    {
        $type = $request->searchType;
        $customers = Customer::query()->with(['customerGroup', 'jobTitle', 'bag']);
        $leads = LeadsCustomers::query()->with(['jobTitle', 'delegate']);

        if ($type === 'name' && $request->filled('name')) {
            $keyword = $request->name;

            // دالة مساعدة مطورة للبحث في قاعدة البيانات
            // قمنا بإضافة: REPLACE للياء الفارسية (ی) وإزالة المسافات لضمان مطابقة الأسماء المركبة
            $normalizeSearch = function ($query, $column, $value) {
                $cleanValue = $this->normalizeArabic($value, true); // تنظيف القيمة المدخلة وتجريدها من المسافات

                return $query->whereRaw("
                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE($column, 
                ' ', ''), 
                'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 
                'ة', 'ه'), 
                'ى', 'ي'), 'ئ', 'ي'), 
                'ی', 'ي') 
                LIKE ?", ["%" . $cleanValue . "%"]);
            };

            $normalizeSearch($customers, 'name_ar', $keyword);
            $normalizeSearch($leads, 'name', $keyword);
        } elseif ($type === 'passport' && $request->filled('passport')) {
            // ... بقية الشروط (جواز السفر، الهوية، الهاتف) تبقى كما هي ...
            $keyword = $request->passport;
            $customers->where('passport_id', 'like', "%{$keyword}%");
            $leads->where('passport_id', 'like', "%{$keyword}%");
        } elseif ($type === 'nid' && $request->filled('nid')) {
            // ... بقية الشروط (جواز السفر، الهوية، الهاتف) تبقى كما هي ...
            $keyword = $request->nid;
            $customers->where('card_id', 'like', "%{$keyword}%");
            $leads->where('card_id', 'like', "%{$keyword}%");
        } elseif ($type === 'phone' && $request->filled('phone')) {
            // ... بقية الشروط (جواز السفر، الهوية، الهاتف) تبقى كما هي ...
            $keyword = $request->phone;
            $customers->where('phone', 'like', "%{$keyword}%");
            $leads->where('phone', 'like', "%{$keyword}%");
        }
        // ... [تكملة بقية الشروط nid و phone] ...

        // تنفيذ البحث وحساب الترتيب
        $customers = $customers->get();
        $leads = $leads->get();

        foreach ($customers as $customer) {
            if ($customer->bag_id) {
                $customer->bag_order = Customer::where('bag_id', $customer->bag_id)
                    ->where('id', '<=', $customer->id)
                    ->count();
            }
        }

        return view('deep-search', compact('customers', 'leads', 'type'));
    }
    private function normalizeArabic($string, $stripSpaces = false)
    {
        if (empty($string)) return "";

        // 1. إزالة التشكيل
        $tashkeel = ["/ُ/", "/ً/", "/ٌ/", "/َّ/", "/ِ/", "/ٍ/", "/ْ/", "/َ/"];
        $string = preg_replace($tashkeel, "", $string);

        // 2. توحيد الحروف الضعيفة والياء الفارسية
        $entities = [
            '/[أإآ]/u' => 'ا',
            '/[ة]/u'    => 'ه',
            '/[ى]/u'    => 'ي',
            '/[ئ]/u'    => 'ي',
            '/[ؤ]/u'    => 'و',
            '/ی/u'      => 'ي', // الياء الفارسية بدون نقاط
        ];
        $string = preg_replace(array_keys($entities), array_values($entities), $string);

        // 3. إزالة الرموز والأرقام والمسافات (إذا كان البحث عن الأسماء المركبة)
        if ($stripSpaces) {
            // إزالة كل شيء عدا الحروف العربية
            $string = preg_replace('/[^\x{0621}-\x{064A}]/u', '', $string);
        } else {
            $string = preg_replace('/\s+/', ' ', $string);
        }

        return trim($string);
    }

    // CustomerController.php
    public function updateNotes(Request $request)
    {
        $customer = Customer::find($request->id);
        if (!$customer) return response()->json(['error' => 'Customer not found'], 404);

        $customer->notes = $request->notes;
        $customer->save();

        return response()->json(['success' => true]);
    }
}
