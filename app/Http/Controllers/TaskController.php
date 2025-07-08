<?php

namespace App\Http\Controllers;

use App\Models\User_task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $tasks = $user->receivedTasks;
        $users = User::where('id', '!=', Auth::id())->get();
        return view('tasks.tasks', [
            'tasks' => $tasks,
            "users" => $users
        ]);
    }
    public function done($id)
    {
        $task = User_task::find($id);
        $task->status = 'done';
        $task->save();
        return redirect()->back();
    }
    public function create(Request $request)
    {
        $request->validate([
            'receiving_user_id' => 'required',
            'description' => 'required',
        ]);
        $user = auth()->user();
        $task = new User_task($request->all());
        $task->sending_user_id = $user->id;
        $task->status = 'new';
        $task->save();

        return redirect()->back();
    }
}
