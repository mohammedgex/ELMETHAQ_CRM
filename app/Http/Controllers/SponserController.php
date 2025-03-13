<?php

namespace App\Http\Controllers;

use App\Models\Sponser;
use Illuminate\Http\Request;

class SponserController extends Controller
{
    //
    public function index($id = null)
    {
        # code...
        $sponserEdit = new Sponser();
        $sponserEdit->name = '';
        $sponserEdit->phone = '';
        $sponserEdit->city = '';

        if (!empty($id)) {
            $sponserEdit = Sponser::find($id);
        }

        $sponsers = Sponser::all();
        return view('sponsor', [
            'sponsers' => $sponsers,
            'sponserEdit' => $sponserEdit,
        ]);
    }
    public function create(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'city' => 'required',
        ]);
        $sponser = new Sponser($request->all());
        $sponser->save();
        return redirect()->route('sponsor.index')->with('success','تم اضافة الكفيل بنجاح');
    }
    public function edit(Request $request, $id)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'city' => 'required',
        ]);
        $sponser = Sponser::find($id);
        $sponser->name = $request->name;
        $sponser->phone = $request->phone;
        $sponser->city = $request->city;
        $sponser->save();
        return redirect()->route('sponsor.index')->with('edit_success',$sponser->name);
    }
    public function delete($id)
    {
        // return $id;
        $sponser = Sponser::find($id);
        if (!$sponser) {
            # code...
            return response()->json([
                'error' => 'the Sponser is not find.'
            ]);
        }
        $sponser->delete();
        return redirect()->route('sponsor.index');
    }
}
