<?php

namespace App\Http\Controllers;

use App\Models\VisaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisaController extends Controller
{
    public function index()
    {
        return view('visa');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:255',
            'visa_type' => 'required|string|max:255',
            'travel_date' => 'required|date|after:today',
            'passport_number' => 'required|string|max:50',
            'passport_expiry' => 'required|date|after:today',
            'nationality' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'الاسم مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'country.required' => 'الدولة مطلوبة',
            'visa_type.required' => 'نوع التأشيرة مطلوب',
            'travel_date.required' => 'تاريخ السفر مطلوب',
            'travel_date.after' => 'تاريخ السفر يجب أن يكون بعد اليوم',
            'passport_number.required' => 'رقم جواز السفر مطلوب',
            'passport_expiry.required' => 'تاريخ انتهاء جواز السفر مطلوب',
            'passport_expiry.after' => 'تاريخ انتهاء جواز السفر يجب أن يكون صالحاً',
            'nationality.required' => 'الجنسية مطلوبة',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        VisaRequest::create($request->all());

        // حفظ الطلب في جدول orders للوحة التحكم
        \App\Models\Order::create([
            'type' => 'visa',
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'details' => json_encode($request->except(['_token'])),
            'status' => 'جديد',
        ]);

        return redirect()->back()->with('success', 'تم إرسال طلب التأشيرة بنجاح! سنتواصل معك قريباً.');
    }
}
