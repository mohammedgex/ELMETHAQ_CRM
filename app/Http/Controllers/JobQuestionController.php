<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobQuestion;
use App\Models\JobTitle;

class JobQuestionController extends Controller
{
    /**
     * تخزين سؤال جديد للوظيفة
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_title_id' => 'required|exists:job_titles,id',
            'question' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,select,radio,checkbox,date,number',
            "show_in_report" => "nullable"
        ]);

        $options = null;
        if (in_array($request->type, ['select', 'radio', 'checkbox']) && $request->options) {
            $options = json_encode(array_map('trim', explode(',', $request->options)));
        }

        JobQuestion::create([
            'job_title_id' => $request->job_title_id,
            'question' => $request->question,
            'type' => $request->type,
            'options' => $options,
            'show_in_report' => $request->show_in_report,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة السؤال بنجاح');
    }

    public function index()
    {
        # code...
        $jobs = JobTitle::get();
        $questions = JobQuestion::get();
        return view("jops.jop_questions", compact('jobs', 'questions'));
    }
    public function destroy($id)
    {

        $question = JobQuestion::find($id);
        if ($question) {
            $question->delete();
            return redirect()->back()->with('success', 'تم حذف السؤال بنجاح');
        }

        return redirect()->back()->with('error', 'السؤال غير موجود');
    }
}
