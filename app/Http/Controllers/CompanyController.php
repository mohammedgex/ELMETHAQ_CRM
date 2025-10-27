<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
  public function apply(Request $request)
  {
    $data = $request->validate([
      'company_name' => 'required',
      'email' => 'required|email',
      'phone' => 'required',
      'job_title' => 'required',
      'workers_count' => 'required|integer|min:1',
      'message' => 'nullable',
    ]);

    // حفظ البيانات في ملف نصي مؤقتاً مع الحالة (pending)
    $line = $data['company_name'] . ' | ' . $data['email'] . ' | ' . $data['phone'] . ' | ' . $data['job_title'] . ' | ' . $data['workers_count'] . ' | ' . ($data['message'] ?? '') . ' | pending' . "\n";
    file_put_contents(storage_path('company_requests.txt'), $line, FILE_APPEND);

    return redirect()->back()->with('success', 'تم تسجيل بيانات الشركة بنجاح وسيتم التواصل معكم قريباً.');
  }

  public function list()
  {
    $requests = [];
    $file = storage_path('company_requests.txt');
    if (file_exists($file)) {
      $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($lines as $index => $line) {
        $parts = explode(' | ', $line);
        $requests[] = [
          'index' => $index,
          'company_name' => $parts[0] ?? '',
          'email' => $parts[1] ?? '',
          'phone' => $parts[2] ?? '',
          'job_title' => $parts[3] ?? '',
          'workers_count' => $parts[4] ?? '',
          'message' => $parts[5] ?? '',
          'status' => $parts[6] ?? 'pending',
        ];
      }
    }
    return view('admin.companies_requests', compact('requests'));
  }

  public function updateStatus(Request $request, $index)
  {
    $status = $request->input('status');
    $file = storage_path('company_requests.txt');
    $message = '';
    if (file_exists($file)) {
      $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      if (isset($lines[$index])) {
        $parts = explode(' | ', $lines[$index]);
        $currentStatus = $parts[6] ?? 'pending';
        if ($currentStatus === 'pending' && in_array($status, ['approved', 'rejected'])) {
          $parts[6] = $status;
          $lines[$index] = implode(' | ', $parts);
          file_put_contents($file, implode("\n", $lines) . "\n");
          $message = ($status === 'approved') ? 'تمت الموافقة على الطلب بنجاح.' : 'تم رفض الطلب بنجاح.';
        } else {
          $message = 'لا يمكن تغيير حالة الطلب بعد الموافقة أو الرفض.';
        }
      }
    }
    return redirect()->back()->with('status_message', $message);
  }
}
