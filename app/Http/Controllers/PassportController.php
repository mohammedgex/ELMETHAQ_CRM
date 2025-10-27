<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassportController extends Controller
{
    public function index()
    {
        return view('passport');
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'type' => 'required|string',
            'country_code1' => 'required|string',
            'city' => 'required|string',
        ]);

        // حفظ الطلب في جدول orders للوحة التحكم
        \App\Models\Order::create([
            'type' => 'passport',
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'details' => json_encode($request->except(['_token'])),
            'status' => 'جديد',
        ]);

        return back()->with('success', 'تم إرسال طلب جواز السفر بنجاح! سنتواصل معك قريباً.');
    }
}
