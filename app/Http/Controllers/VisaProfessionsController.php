<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
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
        $jobs = array('محاسب','سائق حافلة');
        $groups = CustomerGroup::all();

        return view('visa-professions', [
            'visas' => $visas,
            'visaEdit' => $visaEdit,
            'visa_id' => $visa_id,
            "jobs" => $jobs,
            'groups' => $groups
        ]);
    }

    public function create(Request $request, $visa_id)
    {
        # code...
        $request->validate([
            'job' => 'required',
            'job_title' => 'required',
            'profession_count' => 'required',
            'customer_group_id' => 'required',
        ]);

        $visaType = VisaType::find($visa_id);
        $visas = $visaType->visa_professions();
        $visasCount = $visas->sum('profession_count');

        if (intval($visasCount) + intval($request->profession_count) > intval($visaType->count)) {
            # code...
            return redirect()->back()->with('error', 'مجموع عدد المهن تخطي العدد المسموح بيه في التأشيرة, العدد المتبقي هو (' . intval($visaType->count) - intval($visasCount) . ')');
        }

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
            'job_title' => 'required',
            'profession_count' => 'required',
            'customer_group_id' => 'required',
        ]);

        $visa = VisaProfessions::find($id);
        $visa->job = $request->job;
        $visa->profession_count = $request->profession_count;
        $visa->job_title = $request->job_title;
        $visa->customer_group_id = $request->customer_group_id;
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
