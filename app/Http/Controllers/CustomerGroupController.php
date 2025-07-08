<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
            'visa_type_id' => 'nullable'
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
            'visa_type_id' => 'nullable'
        ]);

        $group = CustomerGroup::find($id);
        $group->title = $request->title;
        if ($request->visa_type_id) {
            # code...
            $group->visa_type_id = $request->visa_type_id;
        }
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

    public function assignGroup(Request $request)
    {
        # code...
        $request->validate([
            'customers' => "required|array",
            "group" => 'required'
        ]);
        $group = CustomerGroup::findOrFail($request->group);  // جلب المجموعة من جدول groups

        // تحديث جميع العملاء في المصفوفة وتعيين المجموعة لهم
        $customers = Customer::whereIn('id', $request->customers)->get();

        $currentCount = count($group->customers);
        $newCount = count($customers);
        $limit = intval($group->visaProfession->profession_count);

        if ($currentCount == $limit) {
            return response()->json([
                'message' => "المجموعة مكتملة",
                'error' => true
            ], 400);
        }

        if ($currentCount + $newCount > $limit) {
            return response()->json([
                'message' => "العدد المحدد تخطى العدد المتبقي في المجموعة",
                'error' => true
            ], 400);
        }

        foreach ($customers as $customer) {
            $customer->customer_group_id = $group->id;  // تعيين المجموعة للعميل
            $customer->save();  // حفظ التغييرات
        }
        return response()->json([
            'message' => 'تم تعيين المجموعة بنجاح',
            'status' => true
        ]);
    }
}
