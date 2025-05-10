<?php

namespace App\Http\Controllers;

use App\Models\Embassy;
use App\Models\Sponser;
use App\Models\VisaType;
use Illuminate\Http\Request;

class VisaTypeController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $visaTypeEdit = new VisaType();
        $visaTypeEdit->count = '';
        $visaTypeEdit->outgoing_number = '';
        $visaTypeEdit->registration_number = '';
        $visaTypeEdit->visa_peroid = '';
        $visaTypeEdit->sponser_id = '';
        $visaTypeEdit->embassy_id = '';

        if (!empty($id)) {
            $visaTypeEdit = VisaType::find($id);
        }

        $visa_types = VisaType::all();
        $sponsers = Sponser::all();
        $embassions = Embassy::all();

        return view('visa-type', [
            'visa_types' => $visa_types,
            'visaTypeEdit' => $visaTypeEdit,
            "sponsers" => $sponsers,
            "embassions" => $embassions
        ]);
    }

    public function create(Request $request)
    {
        # code...
        $request->validate([
            'count' => 'required',
            'outgoing_number' => 'required',
            'registration_number' => 'required',
            'visa_peroid' => 'required',
            'sponser_id' => 'required',
            'embassy_id' => 'required',
            'porpose' => "required",
            'name' => "required"
        ]);

        $visa_type = new VisaType($request->all());
        $visa_type->save();
        return redirect()->route('visa-profession.index', ['visa_id' => $visa_type->id, 'id' => null]);
    }

    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'count' => 'required',
            'outgoing_number' => 'required',
            'registration_number' => 'required',
            'visa_peroid' => 'required',
            'sponser_id' => 'required',
            'embassy_id' => 'required',
            'porpose' => "required",
            'name' => "required"
        ]);

        $visa_type = VisaType::find($id);
        $visa_type->count = $request->count;
        $visa_type->outgoing_number = $request->outgoing_number;
        $visa_type->registration_number = $request->registration_number;
        $visa_type->visa_peroid = $request->visa_peroid;
        $visa_type->porpose = $request->porpose;
        $visa_type->name = $request->name;
        $visa_type->sponser_id = $request->sponser_id;
        $visa_type->embassy_id = $request->embassy_id;
        $visa_type->save();
        return redirect()->route('visa-type.index');
    }

    public function delete($id)
    {
        # code...
        $visa_type = VisaType::find($id);
        if (!$visa_type) {
            # code...
            return response()->json([
                'errors' => 'the visa type does not found.'
            ]);
        }
        $visa_type->delete();
        return redirect()->route('visa-type.index');
    }
}
