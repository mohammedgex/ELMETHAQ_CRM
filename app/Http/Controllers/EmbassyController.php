<?php

namespace App\Http\Controllers;

use App\Models\Embassy;
use Illuminate\Http\Request;

class EmbassyController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $embassyEdit = new Embassy();
        $embassyEdit->title = '';

        if (!empty($id)) {
            $embassyEdit = Embassy::find($id);
        }

        $embassies = Embassy::all();

        return view('embassy', [
            'embassies' => $embassies,
            'embassyEdit' => $embassyEdit
        ]);
    }

    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $embassy = new Embassy($request->all());
        $embassy->save();
        return redirect()->route('embassy.index');
    }

    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $embassy = Embassy::find($id);
        $embassy->title = $request->title;
        $embassy->save();
        return redirect()->route('embassy.index');
    }

    public function delete($id)
    {
        # code...
        $embassy = Embassy::find($id);
        if (!$embassy) {
            # code...
            return response()->json([
                'errors' => 'the Evalution does not found.'
            ]);
        }
        $embassy->delete();
        return redirect()->route('embassy.index');
    }
}
