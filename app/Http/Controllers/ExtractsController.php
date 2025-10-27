<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtractsRequest;

class ExtractsController extends Controller
{
  public function index()
  {
    return view('extracts');
  }

  public function store(Request $request)
  {
    // التحقق من صحة البيانات
    $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'required|string|max:20',
      'email' => 'nullable|email',
      'extract_type' => 'required|string',
      'country' => 'required|string',
      'address' => 'required|string',
    ]);

    // حفظ الطلب في جدول orders للوحة التحكم
    \App\Models\Order::create([
      'type' => 'extracts',
      'name' => $request->name,
      'phone' => $request->phone,
      'email' => $request->email,
      'details' => json_encode($request->except(['_token'])),
      'status' => 'جديد',
    ]);

    return back()->with('success', 'تم إرسال طلب المستخرج الرسمي بنجاح! سنتواصل معك قريباً.');
  }
}
