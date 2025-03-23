<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\Evalution;
use App\Models\JobTitle;
use App\Models\Sponser;
use App\Models\VisaType;
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
    public function add()
    {
        // # code...
        $delegates = Delegate::all();
        $evalutions = Evalution::all();
        $groups = CustomerGroup::all();
        $jobs = JobTitle::all();
        $sponsers = Sponser::all();
        $visas = VisaType::all();

        return view('customers.customer-create', [
            'delegates' => $delegates,
            'evalutions' => $evalutions,
            'groups' => $groups,
            'jobs' => $jobs,
            'sponsers' => $sponsers,
            'visas' => $visas
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
        return redirect()->route("customer.indes");
    }
    public function mrz(Request $request, $id)
    {
        # code...
        $customer = Customer::find($id);
        $customer->mrz = $request->mrz;
        $customer->name_en_mrz = $request->name_en_mrz;
        $customer->passport_id = $request->passport_id;
        $customer->nationality = $request->nationality;
        $customer->date_birth = $request->date_birth;
        $customer->passport_expire_date = $request->passport_expire_date;
        $customer->gender = $request->gender;
        $customer->age = $request->age;
        $customer->issue_place = $request->issue_place;
        $customer->save();
        return redirect()->back();
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
