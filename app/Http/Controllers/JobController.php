<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
  public function apply(Request $request)
  {
    $data = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'phone' => 'required',
      'job_title' => 'required',
      'message' => 'required',
    ]);

    // حفظ الطلب في ملف نصي مؤقتاً (يمكن استبداله بقاعدة بيانات لاحقاً)
    $line = implode(' | ', $data) . "\n";
    file_put_contents(storage_path('job_requests.txt'), $line, FILE_APPEND);

    return redirect()->back()->with('success', 'تم إرسال طلبك بنجاح وسيتم التواصل معك قريباً.');
  }

  public function create()
  {
    return view('admin.jobs_create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'title' => 'required',
      'details' => 'required',
      'description' => 'required',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('job_images'), $imageName);
      $data['image'] = $imageName;
    }
    Job::create($data);
    return redirect()->route('admin.jobs.list')->with('success', 'تمت إضافة فرصة العمل بنجاح!');
  }

  public function list()
  {
    $jobs = Job::latest()->get();
    return view('admin.jobs_list', compact('jobs'));
  }

  public function index()
  {
    $jobs = Job::latest()->get();
    return view('jobs', compact('jobs'));
  }

  public function show($id)
  {
    $job = Job::findOrFail($id);
    return view('job_show', compact('job'));
  }

  public function delete($id)
  {
    $job = Job::findOrFail($id);
    if ($job->image && file_exists(public_path('job_images/' . $job->image))) {
      @unlink(public_path('job_images/' . $job->image));
    }
    $job->delete();
    return redirect()->route('admin.jobs.list')->with('success', 'تم حذف الوظيفة بنجاح!');
  }

  public function edit($id)
  {
    $job = Job::findOrFail($id);
    return view('admin.jobs_edit', compact('job'));
  }

  public function update(Request $request, $id)
  {
    $job = Job::findOrFail($id);
    $data = $request->validate([
      'title' => 'required',
      'details' => 'required',
      'description' => 'required',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);
    if ($request->hasFile('image')) {
      // حذف الصورة القديمة
      if ($job->image && file_exists(public_path('job_images/' . $job->image))) {
        @unlink(public_path('job_images/' . $job->image));
      }
      $image = $request->file('image');
      $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('job_images'), $imageName);
      $data['image'] = $imageName;
    }
    $job->update($data);
    return redirect()->route('admin.jobs.list')->with('success', 'تم تعديل الوظيفة بنجاح!');
  }
}
