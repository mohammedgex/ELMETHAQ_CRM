<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightBookingController extends Controller
{
    public function showForm()
    {
        return view('flight-booking');
    }

    public function submitForm(Request $request)
    {
        // يمكنك معالجة البيانات هنا أو حفظها في قاعدة البيانات
        \App\Models\Order::create([
            'type' => 'flight',
            'name' => $request->full_name ?? $request->name ?? '',
            'phone' => $request->phone,
            'email' => $request->email,
            'details' => json_encode($request->except(['_token'])),
            'status' => 'جديد',
        ]);
        return back()->with('success', 'تم إرسال طلبك بنجاح!');
    }
}
