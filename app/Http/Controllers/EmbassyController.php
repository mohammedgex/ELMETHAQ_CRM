<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmbassyRequest;

class EmbassyController extends Controller
{
  public function index()
  {
    return view('embassy');
  }

  public function store(Request $request)
  {
    // التحقق من صحة البيانات
    $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'required|string|max:20',
      'email' => 'nullable|email',
      'service_type' => 'required|string',
      'country' => 'required|string',
      'address' => 'required|string',
    ]);

    // حفظ الطلب في جدول orders للوحة التحكم
    \App\Models\Order::create([
      'type' => 'embassy',
      'name' => $request->name,
      'phone' => $request->phone,
      'email' => $request->email,
      'details' => json_encode($request->except(['_token'])),
      'status' => 'جديد',
    ]);

    return back()->with('success', 'تم إرسال طلب السفارة/القنصلية بنجاح! سنتواصل معك قريباً.');
  }
}
