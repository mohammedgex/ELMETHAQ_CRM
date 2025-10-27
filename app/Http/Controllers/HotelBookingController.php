<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelBookingController extends Controller
{
    public function showForm()
    {
        return view('hotel-booking');
    }

    public function submitForm(Request $request)
    {
        // حفظ الطلب في جدول orders للوحة التحكم
        \App\Models\Order::create([
            'type' => 'hotel',
            'name' => $request->fullname ?? $request->name ?? '',
            'phone' => $request->mobile ?? $request->phone ?? '',
            'email' => $request->email,
            'details' => json_encode($request->except(['_token'])),
            'status' => 'جديد',
        ]);
        return back()->with('success', 'تم إرسال طلبك بنجاح!');
    }
}
