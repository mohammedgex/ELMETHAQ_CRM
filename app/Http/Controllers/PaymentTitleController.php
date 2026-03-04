<?php

namespace App\Http\Controllers;

use App\Models\PaymentTitle;
use Illuminate\Http\Request;

class PaymentTitleController extends Controller
{
    public function index($id = null)
    {
        // جلب جميع السجلات
        $payments = PaymentTitle::all();

        // التحقق مما إذا كنا في وضع التعديل أم الإضافة
        $paymenEdit = $id ? PaymentTitle::find($id) : new PaymentTitle(['title' => '', 'price' => 0]);

        return view('payment-type', compact('payments', 'paymenEdit'));
    }

    public function create(Request $request)
    {
        // 1. التحقق من البيانات (Validation)
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // إضافة التحقق من السعر
        ]);

        // 2. الحفظ (استخدام create أفضل إذا كنت فعلت الـ fillable في الموديل)
        PaymentTitle::create($request->all());

        return redirect()->route('payment-type.index')->with('success', 'تمت إضافة المعاملة بنجاح!');
    }

    public function edit(Request $request, $id)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // 2. التحديث
        $payment = PaymentTitle::findOrFail($id); // findOrFail تعطي 404 تلقائياً إذا لم يوجد
        $payment->update([
            'title' => $request->title,
            'price' => $request->price,
        ]);

        return redirect()->route('payment-type.index')->with('edit_success', $payment->title);
    }

    public function delete($id)
    {
        $payment = PaymentTitle::find($id);

        if (!$payment) {
            return redirect()->route('payment-type.index')->with('error', 'السجل غير موجود');
        }

        $payment->delete();
        return redirect()->route('payment-type.index')->with('delete_success', 'تم الحذف بنجاح');
    }
}
