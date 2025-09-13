<?php

namespace App\Http\Controllers;

use App\Models\JobAnswer;
use App\Models\JobQuestion;
use Illuminate\Http\Request;

class JobAnswerController extends Controller
{
    /**
     * تخزين إجابة عميل على سؤال
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_question_id' => 'required|exists:job_questions,id',
            'answer' => 'required|string|max:500',
        ]);

        // حفظ الإجابة
        JobAnswer::create([
            'job_question_id' => $request->job_question_id,
            'lead_id' =>  auth()->user()->id,
            'answer' => $request->answer,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الإجابة بنجاح ✅'
        ]);
    }

    public function getQuestions($job_title_id)
    {
        // كل الأسئلة الخاصة بالوظيفة
        $questions = JobQuestion::where('job_title_id', $job_title_id)->get();

        return response()->json([
            'status' => true,
            'questions' => $questions
        ]);
    }
    public function getQuestionsWithoutAnswers($job_title_id)
    {
        // 🟢 جيب العميل الحالي من الـ auth
        $lead = auth()->user();

        // 🟢 هات الأسئلة الخاصة بالوظيفة
        $questions = JobQuestion::where('job_title_id', $job_title_id)->get();

        // 🟢 هات IDs الأسئلة اللي العميل جاوب عليها
        $answeredIds = $lead->answers()->pluck('job_question_id')->toArray();

        // 🟢 رجع الأسئلة اللي لسه مجابش عليها
        $unanswered = $questions->whereNotIn('id', $answeredIds)->values();

        return response()->json([
            'status' => true,
            'questions' => $unanswered
        ]);
    }
}
