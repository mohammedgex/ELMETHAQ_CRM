<?php

namespace App\Http\Controllers;

use App\Models\Evalution;
use Illuminate\Http\Request;

class EvalutionController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $evalutionEdit = new Evalution();
        $evalutionEdit->title = '';

        if (!empty($id)) {
            $evalutionEdit = Evalution::find($id);
        }

        $evalutions = Evalution::all();

        return view('evaluation', [
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

        $evaluation = new Evalution($request->all());
        $evaluation->save();
        return redirect()->route('evaluation.index')->with('success', 'تمت إضافة التقييم بنجاح!');
    }

    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $evaluation = Evalution::find($id);
        $evaluation->title = $request->title;
        $evaluation->save();
        return redirect()->route('evaluation.index')->with('edit_success', $evaluation->title);
    }

    public function delete($id)
    {
        # code...
        $evaluation = Evalution::find($id);
        if (!$evaluation) {
            # code...
            return response()->json([
                'errors' => 'the Evalution does not found.'
            ]);
        }
        $evaluation->delete();
        return redirect()->route('evaluation.index')->with('delete_success','');
    }
}
