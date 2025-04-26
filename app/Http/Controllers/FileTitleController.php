<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;

class FileTitleController extends Controller
{
    public function sendFile(Request $request, $id)
    {
        # code...
        $request->validate([
            'file' => 'required'
        ]);
        $document = DocumentType::find($id);
        if (!$document) {
            # code...
            return response()->json([
                'error' => 'Document not found'
            ]);
        }

        $filePath = $request->file('file')->store('uploads', 'public');

        $document->file =  $filePath;
        $document->order_status =  'panding';
        $document->save();
        return response()->json([
            'success' => true
        ]);
    }
    public function accept($id)
    {
        # code...
        $document = DocumentType::find($id);
        if (!$document) {
            # code...
            return response()->json([
                'error' => 'Document not found'
            ]);
        }
        $document->order_status =  'accept';
        $document->save();
        return redirect()->route("customer.add", $document->customer_id)->with('tap', 'attach');
    }
    public function reject($id)
    {
        # code...
        $document = DocumentType::find($id);
        if (!$document) {
            # code...
            return response()->json([
                'error' => 'Document not found'
            ]);
        }
        $document->order_status = 'reject';
        $document->save();
        return redirect()->route("customer.add", $document->customer_id)->with('tap', 'attach');
    }
}
