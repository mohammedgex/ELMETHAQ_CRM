<?php

namespace App\Http\Controllers;

use App\Models\VisaProfessions;
use App\Models\VisaType;
use Illuminate\Http\Request;

class VisaProfessionsController extends Controller
{
    //

    public function index($visa_id, $id = null)
    {
        // # code...
        $visaEdit = new VisaProfessions();
        $visaEdit->profession_count = '';

        if (!empty($id)) {
            $visaEdit = VisaProfessions::find($id);
        }

        $visaType = VisaType::find($visa_id);
        $visas = $visaType->visa_professions;
        $jobs = array('محاسب', 'سائق');

        return view('visa-professions', [
            'visas' => $visas,
            'visaEdit' => $visaEdit,
            'visa_id' => $visa_id,
            "jobs" => $jobs
        ]);
    }

    public function create(Request $request, $visa_id)
    {
        # code...
        $request->validate([
            'job' => 'required',
            'profession_count' => 'required',
        ]);

        $visa = new VisaProfessions($request->all());
        $visa->visa_type_id = $visa_id;
        $visa->save();
        return redirect()->back()->with('success', 'تمت إضافة المجموعة بنجاح!');
    }
    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'job' => 'required',
            'profession_count' => 'required',
        ]);

        $visa = VisaProfessions::find($id);
        $visa->job = $request->job;
        $visa->profession_count = $request->profession_count;
        $visaType = $visa->visa_type_id;
        $visa->save();
        return redirect()->route('visa-profession.index', ['visa_id' => $visaType, 'id' => null])->with('edit_success', value: $visa->title);
    }

    public function delete($id)
    {
        # code...
        $visa = VisaProfessions::find($id);
        $visaType = $visa->visa_type_id;
        if (!$visa) {
            # code...
            return response()->json([
                'errors' => 'the Visa Professions does not found.'
            ]);
        }
        $visa->delete();
        return redirect()->route('visa-profession.index', ['visa_id' => $visaType, 'id' => null])->with('delete_success', '');
    }
}
