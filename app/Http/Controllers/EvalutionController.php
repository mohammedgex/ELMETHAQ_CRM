<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvalutionController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $evalutionEdit = new Evaluation();
        $evalutionEdit->title = '';

        if (!empty($id)) {
            $evalutionEdit = Evaluation::find($id);
        }

        $evalutions = Evaluation::all();

        return view('Evaluation', [
            'evaluations' => $evalutions,
            'evaluationEdit' => $evalutionEdit
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $evaluation = new Evaluation($request->all());
        $evaluation->save();
        return redirect()->route('evaluation.index')->with('success', 'تمت إضافة التقييم بنجاح!');
    }

    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $evaluation = Evaluation::find($id);
        $evaluation->title = $request->title;
        $evaluation->save();
        return redirect()->route('evaluation.index')->with('edit_success', $evaluation->title);
    }

    public function delete($id)
    {
        # code...
        $evaluation = Evaluation::find($id);
        if (!$evaluation) {
            # code...
            return response()->json([
                'errors' => 'the Evalution does not found.'
            ]);
        }
        $evaluation->delete();
        return redirect()->route('evaluation.index')->with('delete_success', '');
    }
}
