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
            return response()->json(['error' => 'Customer not found']);
        }

        $blackList = BlackList::firstOrCreate(
            ['customer_id' => $customer->id],
            ['block' => false]
        );

        $blackList->block = true;
        $blackList->save();
        return redirect()->route('customer.indes');
    }
    public function unBlock($id)
    {
        # code...
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found']);
        }

        $blackList = BlackList::firstOrCreate(
            ['customer_id' => $customer->id],
            ['block' => false]
        );

        $blackList->block = false;
        $blackList->save();
        return redirect()->route('customer.indes');
    }
}
