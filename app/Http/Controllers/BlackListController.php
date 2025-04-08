<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Customer;
use Illuminate\Http\Request;

class BlackListController extends Controller
{
    //
    public function block($id)
    {
        # code...

        $customer = Customer::find($id);
        if (!$customer) {
            # code...
            return response()->json([
                'error' => 'Customer not found'
            ]);
        }
        # code...
        $blackList = BlackList::where('customer_id', $customer->id)->first();
        $blackList->block = true;
        $blackList->save();
        return redirect()->back();
    }
    public function unBlock($id)
    {
        # code...
        $customer = Customer::find($id);
        if (!$customer) {
            # code...
            return response()->json([
                'error' => 'Customer not found'
            ]);
        }
        $blackList = BlackList::where('customer_id', $customer->id)->first();
        $blackList->block = false;
        $blackList->save();
        return redirect()->back();
    }
}
