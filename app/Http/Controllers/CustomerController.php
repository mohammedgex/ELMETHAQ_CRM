<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\Evaluation;
use App\Models\FileTitle;
use App\Models\History;
use App\Models\JobTitle;
use App\Models\Payments;
use App\Models\PaymentTitle;
use App\Models\Sponser;
use App\Models\VisaType;
use Carbon\Carbon;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Response;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function add($id = null)
    {
        // # code...
        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $fileTitles = FileTitle::all();
        $paymentTitles = PaymentTitle::all();
        $visas = VisaType::all();
        $validVisas = [];
        foreach ($visas as $visa) {

            $visasCount = $visa->visa_professions()->sum('profession_count');

            if (intval($visasCount) < intval($visa->count)) {
                # code...
                $validVisas[] = $visa;
            }
        }

        $customer = [];
        if ($id == null) {
            # code...
            $files = [];
            $payments = [];
            $histories = [];
        } else {
            $customer = Customer::find($id);

            $files = $customer->documentTypes;
            $payments = $customer->payments;
            $histories = $customer->histories;
        }



        return view('customers.customer-create', [
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $validVisas,
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
        $delegates = Delegate::all();
        $evalutions = Evaluation::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        $customers = Customer::all();

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

    public function basicDetails(Request $request)
    {
        $validatedData = $request->all();

        // لو فيه صورة، ضيفها إلى الـ array
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('uploads', 'public');
            $validatedData['image'] = $filePath;
        }

        // إنشاء العميل بكل البيانات دفعة واحدة
        $customer = Customer::create($validatedData);

        // إضافة للسجل الأسود (block = false)
        $blackList = new BlackList();
        $blackList->block = false;
        $blackList->customer_id = $customer->id;
        $blackList->save();

        return redirect()->route("customer.add", $customer->id)->with('tap', 'info');
    }

    public function editBasicDetails(Request $request, $id)
    {
        $customer = Customer::find($id);

        $data = $request->all();

        // لو فيه صورة
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('uploads', 'public');
            $data['image'] = $filePath;
        }

        // تحديث البيانات كلها
        $customer->update($data);

        return redirect()->route("customer.add", $customer->id)->with('tap', 'info');
    }


    public function mrz(Request $request, $id)
    {
        $customer = Customer::find($id);

        // تحويل تاريخ الميلاد إلى التنسيق الصحيح
        $date_birth = Carbon::createFromFormat('d/m/Y', $request->date_birth)->format('Y-m-d');
        $customer->date_birth = $date_birth; // التاريخ بصيغة Y-m-d

        // تحويل تاريخ انتهاء الجواز إلى التنسيق الصحيح
        $passport_expire_date = Carbon::createFromFormat('d/m/Y', $request->passport_expire_date)->format('Y-m-d');
        $customer->passport_expire_date = $passport_expire_date; // التاريخ بصيغة Y-m-d

        $customer->mrz = $request->mrz;
        if ($request->hasFile('mrz_image')) {
            $filePath = $request->file('mrz_image')->store('uploads', 'public');
            $customer->mrz_image = $filePath;
        }
        $customer->passport_id = $request->passport_id;
        $customer->nationality = $request->nationality;
        $customer->gender = $request->gender;
        $customer->age = $request->age;
        $customer->issue_place = $request->issue_place;
        $customer->name_en_mrz = $request->name_en_mrz;
        $customer->name_ar = app(GoogleTranslateController::class)->translateText($request->name_en_mrz);

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

    public function exportCustomers()
    {

        // Define file path
        $filePath = storage_path('app/public/all-customers.xlsx');

        // Fetch delegates data
        $customers = Customer::all();
        // Define header style
        /* Create a border around a cell */
        $border = new Border(
            new BorderPart(Border::BOTTOM, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::TOP, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID)
        );

        $style = (new Style())
            ->setFontBold()
            ->setFontSize(15)
            ->setFontColor(Color::BLUE)
            ->setShouldWrapText()
            ->setBackgroundColor(Color::YELLOW)
            ->setBorder($border);

        $headerStyle = (new Style())
            ->setFontBold()
            ->setFontSize(50)
            ->setFontColor(Color::BLACK)
            ->setBackgroundColor(Color::BLUE);

        // Create and write to Excel file
        $writer = SimpleExcelWriter::create($filePath)
            ->addHeader(['ID', 'Name', 'Phone', 'Card ID'])
            ->setHeaderStyle($style);

        $writer->addRow([
            $customers->id,
            $customers->name,
            $customers->phone,
            $customers->card_id
        ], $style);


        // Return the file for download
        return Response::download($filePath, name: 'customer_' . $customers->name . '.xlsx')->deleteFileAfterSend();
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
        $customers = Customer::where($searchBy, 'LIKE', "%$searchInput%")->get();


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
        $customers = Customer::all();

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
}
