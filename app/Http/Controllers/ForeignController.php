<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForeignController extends Controller
{
    public function index()
    {
        return view('foreign');
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'document_type' => 'required|string',
            'country' => 'required|string',
            'address' => 'required|string',
        ]);

        // حفظ الطلب في جدول orders للوحة التحكم
        \App\Models\Order::create([
            'type' => 'foreign',
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'details' => json_encode($request->except(['_token'])),
            'status' => 'جديد',
        ]);

        return back()->with('success', 'تم إرسال طلب التوثيق الخارجي بنجاح! سنتواصل معك قريباً.');
    }
}
