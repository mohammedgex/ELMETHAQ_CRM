<?php

namespace App\Http\Controllers;

use App\Models\FileTitle;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $documenEdit = new FileTitle();
        $documenEdit->title = '';

        if (!empty($id)) {
            $documenEdit = FileTitle::find($id);
        }

        $documents = FileTitle::all();

        return view('document-type', [
            'documents' => $documents,
            'documenEdit' => $documenEdit
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $group = new FileTitle($request->all());
        $group->save();
        return redirect()->route('document-type.index');
    }

    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $document = FileTitle::find($id);
        $document->title = $request->title;
        $document->save();
        return redirect()->route('document-type.index');
    }

    public function delete($id)
    {
        # code...
        $document = FileTitle::find($id);
        if (!$document) {
            # code...
            return response()->json([
                'errors' => 'the document does not found.'
            ]);
        }
        $document->delete();
        return redirect()->route('document-type.index');
    }
}
