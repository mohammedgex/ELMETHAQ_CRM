<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    //

    public function index($id = null)
    {
        # code...
        $groupEdit = new CustomerGroup();
        $groupEdit->name = '';
        $groupEdit->phone = '';
        $groupEdit->card_id = '';

        if (!empty($id)) {
            $groupEdit = CustomerGroup::find($id);
        }

        $groups = CustomerGroup::all();

        return view('groups', [
            'groups' => $groups,
            'groupEdit' => $groupEdit
        ]);
    }

    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $group = new CustomerGroup($request->all());
        $group->save();
        return redirect()->route('customer-groups.index');
    }
    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $group = CustomerGroup::find($id);
        $group->title = $request->title;
        $group->save();
        return redirect()->route('customer-groups.index');
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
        return redirect()->route('customer-groups.index');
    }
}
