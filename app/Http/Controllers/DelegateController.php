<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delegate;
use PhpParser\Node\Stmt\Return_;

class DelegateController extends Controller
{
    public function index($id = null)
    {
        $delegateEdit = new Delegate();
        $delegateEdit->name = '';
        $delegateEdit->phone = '';
        $delegateEdit->card_id = '';

        if (!empty($id)) {
            $delegateEdit = Delegate::find($id);
        }

        $delegates = Delegate::all();
        return view('/Delegates', [
            'delegates' => $delegates,
            'delegatesEdit' => $delegateEdit
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
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'card_id' => 'required|string',
        ]);
        $delegate = Delegate::find($id);
        if (!$delegate) {
            return response()->json([
                'error' => 'the delegate is not found.',
            ]);
        }
        $delegate->name = $request->name;
        $delegate->phone = $request->phone;
        $delegate->card_id = $request->card_id;
        $delegate->save();
        return redirect()->route('Delegates.create');
    }

    public function delete($id)
    {
        // return $id;
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