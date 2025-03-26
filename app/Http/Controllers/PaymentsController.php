<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    public function delete($id)
    {
        # code...
        $payment = Payments::find();
        if (!$payment) {
            # code...
            return response()->json([
                'errors' => 'payment not found',
            ]);
        }
        $payment->delete();
        return redirect()->back();
    }
}
