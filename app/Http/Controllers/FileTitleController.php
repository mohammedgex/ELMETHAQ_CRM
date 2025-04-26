<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\FileTitle;
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
    public function showedit($id)
    {
        $document = DocumentType::find($id);

        if (!$document) {
            abort(404);
        }

        $customer = $document->customer;

        // كل التايتلات المستخدمة عند العميل هذا ماعدا التايتل الحالي
        $usedTitles = $customer->documentTypes()
            ->where('id', '!=', $id)
            ->pluck('document_type')
            ->toArray();

        // التايتلات اللي مش مستخدمة أو التايتل الحالي
        $fileTitles = FileTitle::whereNotIn('title', $usedTitles)->get();

        return view("edit-attachment", [
            'edit' => $document,
            'fileTitles' => $fileTitles
        ]);
    }

    public function updateAttachment(Request $request, $id)
    {
        // ✅ تحقق من صحة البيانات
        $request->validate([
            'document_type' => 'required|string|max:255',
            'status' => 'required|string',
            'required' => 'required|in:true,false',
            'note' => 'nullable|string|max:1000',
            'file' => 'nullable',
        ]);

        // ✅ جلب المرفق
        $attachment = DocumentType::findOrFail($id);
        $customer = $attachment->customer;

        // ✅ تعديل البيانات
        $attachment->document_type = $request->document_type;
        $attachment->status = $request->status;
        $attachment->required = $request->required;
        $attachment->note = $request->note;

        // ✅ لو فيه ملف جديد
        if ($request->hasFile('file')) {
            // رفع الملف الجديد
            $path = $request->file('file')->store('uploads', 'public');
            $attachment->file = $path;
        }

        // ✅ حفظ التعديلات
        $attachment->save();

        // ✅ إعادة التوجيه مع رسالة نجاح
        return redirect()->route("customer.add", $customer->id)->with('tap', 'attach');
    }

    public function toAttach($id)
    {
        # code...
        return redirect()->route("customer.add", $id)->with('tap', 'attach');
    }


    public function delete($id)
    {
        # code...
        $file = DocumentType::find($id);
        $customer = $file->customer;
        $file->delete();
        return redirect()->route("customer.add", $customer->id)->with('tap', 'attach');
    }
}
