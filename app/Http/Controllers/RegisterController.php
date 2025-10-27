<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function apply(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'job_title' => 'required',
      'email' => 'required|email',
      'phone' => 'required',
      'cv' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
      'message' => 'nullable',
    ]);

    $cvPath = null;
    if ($request->hasFile('cv')) {
      $cv = $request->file('cv');
      $cvName = time() . '_' . uniqid() . '.' . $cv->getClientOriginalExtension();
      $cv->move(public_path('cvs'), $cvName);
      $cvPath = 'cvs/' . $cvName;
    }

    // حفظ البيانات في ملف نصي مؤقتاً
    $line = $data['name'] . ' | ' . $data['job_title'] . ' | ' . $data['email'] . ' | ' . $data['phone'] . ' | ' . ($cvPath ?? 'بدون سيرة ذاتية') . ' | ' . ($data['message'] ?? '') . "\n";
    file_put_contents(storage_path('register_requests.txt'), $line, FILE_APPEND);

    return redirect()->back()->with('success', 'تم تسجيل بياناتك بنجاح وسيتم التواصل معك قريباً.');
  }

  public function list()
  {
    $workers = \App\Models\Worker::latest()->paginate(10);
    return view('admin.registrations', compact('workers'));
  }
}
