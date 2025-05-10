<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use App\Models\VisaType;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    //

    public function index($id = null)
    {
        # code...
        $groupEdit = new CustomerGroup();
        $groupEdit->title = '';

        if (!empty($id)) {
            $groupEdit = CustomerGroup::find($id);
        }

        $visas = VisaType::all();
        $groups = CustomerGroup::all();

        return view('groups', [
            'groups' => $groups,
            'groupEdit' => $groupEdit,
            'visas' => $visas
        ]);
    }

    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required',
            'visa_type_id' => 'required'
        ]);

        $group = new CustomerGroup($request->all());
        $group->save();
        return redirect()->route('customer-groups.index')->with('success', 'تمت إضافة المجموعة بنجاح!');
    }
    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required',
            'visa_type_id' => 'required'
        ]);

        $group = CustomerGroup::find($id);
        $group->title = $request->title;
        $group->visa_type_id = $request->visa_type_id;
        $group->save();
        return redirect()->route('customer-groups.index')->with('edit_success', value: $group->title);
    }

    public function delete($id)
    {
        # code...
        $group = CustomerGroup::find($id);
        if (!$group) {
            # code...
            return response()->json([
                'errors' => 'the group does not found.'
            ]);
        }
        $group->delete();
        return redirect()->route('customer-groups.index')->with('delete_success', '');
    }
}
