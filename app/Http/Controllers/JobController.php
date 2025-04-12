<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
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
        return redirect()->route('job-type.index')->with('edit_success',value: $job->title);
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
        return redirect()->route('job-type.index')->with('delete_success','');
    }
}
