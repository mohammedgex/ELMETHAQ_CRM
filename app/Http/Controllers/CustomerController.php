<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Delegate;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Response;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class CustomerController extends Controller
{
    //
    public function index(){
        $delegates = Delegate::all();
        return view("user-create",[
            "delegates"=> $delegates
        ]);
    }


    public function create(Request $request){
        $customer = new Customer($request->all());
        $customer->passport_id = 'fdshsgfddsh';
        $customer->visa_type_id = "1";
        $customer->visa_peroid_id = "1";
        $customer->customer_group_id = "1";
        $customer->sponser_id = "1";
        $customer->evalution_id = "1";
        $customer->embassy_id = "1";
        $customer->job_title_id = "1";
        $customer->save();

        return redirect()->route('workers');

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
        return Response::download($filePath, name: 'customer_'.$customers->name.'.xlsx')->deleteFileAfterSend();
    }
}
