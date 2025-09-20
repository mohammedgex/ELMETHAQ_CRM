<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use App\Models\LeadsCustomers;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $jobEdit = new JobTitle();
        $jobEdit->title = '';

        if (!empty($id)) {
            $jobEdit = JobTitle::find($id);
        }

        $jobs = JobTitle::all();

        return view('job-type', [
            'jobs' => $jobs,
            'jobEdit' => $jobEdit
        ]);
    }

    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $job = new JobTitle($request->all());
        $job->save();
        return redirect()->route('job-type.index')->with('success', 'تمت إضافة الوظيفة بنجاح!');
    }

    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $job = JobTitle::find($id);
        $job->title = $request->title;
        $job->save();
        return redirect()->route('job-type.index')->with('edit_success', value: $job->title);
    }

    public function delete($id)
    {
        # code...
        $job = JobTitle::find($id);
        if (!$job) {
            # code...
            return response()->json([
                'errors' => 'the job does not found.'
            ]);
        }
        $job->delete();
        return redirect()->route('job-type.index')->with('delete_success', '');
    }

    public function apiIndex()
    {
        $jobs = JobTitle::where("show_in_app", "yes")->get();
        return response()->json($jobs);
    }

    public function show_in_app($id)
    {
        # code...
        $job = JobTitle::find($id);
        if (!$job) {
            # code...
            return redirect()->back()->with('error', 'the job does not found.');
        }
        if ($job->show_in_app === 'yes') {
            $job->show_in_app = 'no';
        } elseif ($job->show_in_app === 'no') {
            $job->show_in_app = 'yes';
        } else { // يعني null أو أي قيمة تانية غير yes/no
            $job->show_in_app = 'no';
        }

        $job->save();
        return redirect()->back()->with('success', 'تم التعديل بنجاح!');
    }

    public function filler()
    {
        # code...
        $job_titles = JobTitle::all();
        return view('deepFilter.job-fillter', [
            'job_titles' => $job_titles
        ]);
    }

    public function filter(Request $request)
    {
        $jobId   = $request->job_title_id;
        $answers = $request->answers ?? [];

        $query = LeadsCustomers::query();

        // 1️⃣ فلترة حسب الوظيفة فقط إذا موجودة
        if ($jobId) {
            $query->where('job_title_id', $jobId);
        }

        // 2️⃣ فلترة حسب الإجابات إذا موجودة
        // تنظيف الإجابات: حذف null أو قيم فارغة
        $answers = array_filter($answers ?? [], fn($val) => !is_null($val) && $val !== '');

        if (!empty($answers)) {
            foreach ($answers as $questionId => $answer) {
                $query->whereHas('answers', function ($subQ) use ($questionId, $answer) {
                    $subQ->where('job_question_id', $questionId);

                    if (is_array($answer)) {
                        // فقط القيم الصالحة
                        $validAnswers = array_filter($answer, fn($val) => !is_null($val) && $val !== '');
                        if (!empty($validAnswers)) {
                            $subQ->whereIn('answer', $validAnswers);
                        }
                    } else {
                        $subQ->where('answer', 'like', "%{$answer}%");
                    }
                });
            }
        }



        $leads = $query->get();
        $job_titles = JobTitle::all();

        return view('deepFilter.job-fillter', compact('leads', 'job_titles'));
    }
}
