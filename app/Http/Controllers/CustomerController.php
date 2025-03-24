<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\Evalution;
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
        $evalutions = Evalution::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();
        $fileTitles = FileTitle::all();
        $paymentTitles = PaymentTitle::all();

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
        $delegates = Delegate::all();
        return view(view: "customers.customer", data: [
            "delegates" => $delegates
        ]);
    }


    public function basicDetails(Request $request)
    {
        $validatedData = $request->all();

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('uploads', 'public');
        }
        $customer = new Customer($validatedData);

        $customer->save();
        return redirect()->route("customer.add", $customer->id);
    }
    public function editBasicDetails(Request $request, $id)
    {

        if ($request->hasFile('image')) {
            $request['image'] = $request->file('image')->store('uploads', 'public');
        }
        $customer =  Customer::find($id);
        $customer->update($request->all());

        return redirect()->route("customer.add", $customer->id);
    }

    public function mrz(Request $request, $id)
    {
        $customer = Customer::find($id);

        // تحويل تاريخ الميلاد إلى التنسيق الصحيح
        $date_birth = Carbon::createFromFormat('d/m/Y', $request->date_birth)->format('Y-m-d');

        // تحويل تاريخ انتهاء الجواز إلى التنسيق الصحيح
        $passport_expire_date = Carbon::createFromFormat('d/m/Y', $request->passport_expire_date)->format('Y-m-d');

        $customer->mrz = $request->mrz;
        $customer->name_en_mrz = $request->name_en_mrz;
        $customer->passport_id = $request->passport_id;
        $customer->nationality = $request->nationality;
        $customer->date_birth = $date_birth; // التاريخ بصيغة Y-m-d
        $customer->passport_expire_date = $passport_expire_date; // التاريخ بصيغة Y-m-d
        $customer->gender = $request->gender;
        $customer->age = $request->age;
        $customer->issue_place = $request->issue_place;

        $customer->save();

        return redirect()->route("customer.add", $customer->id);
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

        $document->save();

        return redirect()->route("customer.add", $customer->id);
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

        return redirect()->route("customer.add", $customer->id);
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

        return redirect()->route("customer.add", $customer->id);
    }

    public function show($id)
    {
        # code...
        $customer = Customer::find($id);
        return view('customers.customer-show');
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
}
