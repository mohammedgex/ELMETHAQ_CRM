<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    //
    public function delete($id)
    {
        # code...
        $history = History::find($id);
        if (!$history) {
            # code...
            return response()->json([
                'errors' => 'history not found',
            ]);
        }
        $history->delete();
        return redirect()->back();
    }
}
