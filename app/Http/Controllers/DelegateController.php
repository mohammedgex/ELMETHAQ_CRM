<?php

namespace App\Http\Controllers;
use TCPDF;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Delegate;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Response;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use Barryvdh\Snappy\Facades\SnappyPdf;

class DelegateController extends Controller
{
    public function index($id = null)
    {
        $delegateEdit = new Delegate();
        $delegateEdit->name = '';
        $delegateEdit->phone = '';
        $delegateEdit->card_id = '';

        if (!empty($id)) {
            $delegateEdit = Delegate::find($id);
        }

        $delegates = Delegate::all();
        return view('/Delegates', [
            'delegates' => $delegates,
            'delegatesEdit' => $delegateEdit
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'card_id' => 'required|string',
        ]);

        Delegate::create(attributes: $request->all());

        return redirect()->back()->with('success', 'تمت إضافة المندوب بنجاح!');
    }
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'card_id' => 'required|string',
        ]);
        $delegate = Delegate::find($id);
        if (!$delegate) {
            return response()->json([
                'error' => 'the delegate is not found.',
            ]);
        }
        $delegate->name = $request->name;
        $delegate->phone = $request->phone;
        $delegate->card_id = $request->card_id;
        $delegate->save();
        return redirect()->route('Delegates.create');
    }

    public function delete($id)
    {
        // return $id;
        $delegate = Delegate::find($id);
        if (!$delegate) {
            # code...
            return response()->json([
                'error' => 'the delegate is not find.'
            ]);
        }
        $delegate->delete();
        return redirect()->route('Delegates.create')->with('success', 'successs');
    }

     public function exportDelegates($id)
    {

        // Define file path
        $filePath = storage_path('app/public/delegates.xlsx');

        // Fetch delegates data
        $delegate = Delegate::find($id); 
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
                $delegate->id,
                $delegate->name,
                $delegate->phone,
                $delegate->card_id
            ], $style);
        

        // Return the file for download
        return Response::download($filePath, name: 'delegate_'.$delegate->name.'.xlsx')->deleteFileAfterSend();
    }

        // طباعة pdf المندوب
        public function downloadPdf($id)
            {
                // Fetch delegate data (change '1' to a dynamic value if needed)
                $delegate = Delegate::find($id); 

                
                // Check if delegate exists
                if (!$delegate) {
                    return abort(404, message: 'Delegate not found');
                }

                // Load the Blade view with delegate data
                $pdf = SnappyPdf::loadView('pdf.invoice', ['delegate' => $delegate])
                    ->setPaper('a4');

                // Download the PDF
                return $pdf->download("delegate_{$delegate->name}.pdf");
            }

}