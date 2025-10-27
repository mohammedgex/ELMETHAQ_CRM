<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranslationRequest;

class TranslationController extends Controller
{
  public function index()
  {
    return view('translation');
  }

  public function store(Request $request)
  {
    // التحقق من صحة البيانات
    $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'required|string|max:20',
      'email' => 'nullable|email',
      'translation_type' => 'required|string',
      'from_language' => 'required|string',
      'to_language' => 'required|string',
      'address' => 'required|string',
    ]);

    // حفظ الطلب في جدول orders للوحة التحكم
    \App\Models\Order::create([
      'type' => 'translation',
      'name' => $request->name,
      'phone' => $request->phone,
      'email' => $request->email,
      'details' => json_encode($request->except(['_token'])),
      'status' => 'جديد',
    ]);

    return back()->with('success', 'تم إرسال طلب الترجمة المعتمدة بنجاح! سنتواصل معك قريباً.');
  }
}
