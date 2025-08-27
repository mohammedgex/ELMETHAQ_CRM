<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Customer;
use App\Models\History;
use Carbon\Carbon;
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
        $history = new History();
        $history->description = "تم حظر العميل من قبل " . auth()->user()->name;
        $history->date = Carbon::now();
        $history->customer_id = $customer->id;
        $history->user_id = auth()->id();
        $history->save();
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
        $history = new History();
        $history->description = "تم فك الحظر عن العميل من قبل " . auth()->user()->name;
        $history->date = Carbon::now();
        $history->customer_id = $customer->id;
        $history->user_id = auth()->id();
        $history->save();
        return redirect()->route('customer.indes');
    }
}
