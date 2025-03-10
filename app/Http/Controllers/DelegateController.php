<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delegate;

class DelegateController extends Controller
{
    public function index()
    {
        $delegates = Delegate::all();
        return view('/Delegates', [
            'delegates' => $delegates
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'card_id' => 'required|string',
        ]);

        Delegate::create(attributes: $request->all());

        return redirect()->back()->with('success', 'تمت إضافة المندوب بنجاح!');
    }
    public function delete($id)
    {
        $delegate = Delegate::find($id);
        if (!$delegate) {
            # code...
            return response()->json([
                'error' => 'the delegate is not find.'
            ]);
        }
        $delegate->delete();
        return redirect()->route('Delegates.create');
    }
}
