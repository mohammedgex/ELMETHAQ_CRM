<?php

namespace App\Http\Controllers;

use App\Models\PaymentTitle;
use Illuminate\Http\Request;

class PaymentTitleController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $paymenEdit = new PaymentTitle();
        $paymenEdit->title = '';

        if (!empty($id)) {
            $paymenEdit = PaymentTitle::find($id);
        }

        $payments = PaymentTitle::all();

        return view('payment-type', [
            'payments' => $payments,
            'paymenEdit' => $paymenEdit
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $payment = new PaymentTitle($request->all());
        $payment->save();
        return redirect()->route('payment-type.index')->with('success', 'تمت إضافة المعاملة بنجاح!');
    }


    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'title' => 'required'
        ]);

        $payment = PaymentTitle::find($id);
        $payment->title = $request->title;
        $payment->save();
        return redirect()->route('payment-type.index')->with('edit_success',value: $payment->title);
    }

    public function delete($id)
    {
        # code...
        $payment = PaymentTitle::find($id);
        if (!$payment) {
            # code...
            return response()->json([
                'errors' => 'the payment does not found.'
            ]);
        }
        $payment->delete();
        return redirect()->route('payment-type.index')->with('delete_success','');
    }
}
