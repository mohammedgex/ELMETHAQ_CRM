<?php

namespace App\Http\Controllers;

use App\Models\bag;
use App\Models\Customer;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BagController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $bagEdit = new bag();
        $bagEdit->name = '';

        if (!empty($id)) {
            $bagEdit = bag::find($id);
        }

        $bags = bag::all();
        return view('bags.bag-index', [
            'bags' => $bags,
            'bagEdit' => $bagEdit,
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'leave_date' => 'required',
            'transportation' => 'required',
        ]);
        $bag = new bag($request->all());
        $bag->save();
        return redirect()->route('bags.index')->with('success', 'تم اضافة الحقيبة بنجاح');
    }
    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'transportation' => 'required',
            'leave_date' => 'required',
        ]);
        $bag = bag::find($id);
        $bag->name = $request->name;
        $bag->transportation = $request->transportation;
        $bag->leave_date = $request->leave_date;
        $bag->save();
        return redirect()->route('bags.index')->with('edit_success', $bag->name);
    }

    public function delete($id)
    {
        // return $id;
        $bag = bag::find($id);
        if (!$bag) {
            # code...
            return response()->json([
                'error' => 'the bag is not find.'
            ]);
        }
        $bag->delete();
        return redirect()->route('bags.index');
    }

    public function bagCustomers($bag_id)
    {
        # code...
        $bag = bag::find($bag_id);
        return view('group-customers', [
            'customers' => $bag->customers,
            'bag' => $bag
        ]);
    }

    public function assignBag(Request $request)
    {
        $request->validate([
            'customers' => 'required|array',
            'bag' => 'required|exists:bags,id'
        ]);

        $customers = Customer::whereIn('id', $request->customers)->get();

        foreach ($customers as $customer) {
            $customer->bag_id = $request->bag;
            $customer->save();
            $history = new History();
            $history->description = "تم تعيين الحقيبة للعميل";
            $history->date = Carbon::now();
            $history->customer_id = $customer->id;
            $history->user_id = User::where('email', $request->email)->first()->id;
            $history->save();
        }

        return response()->json(['message' => 'تم تعيين الحقيبة بنجاح']);
    }
}
