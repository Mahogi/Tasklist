<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tasks;

class TaskController extends Controller
{
    function create(Request $request)
    {
        $creator = $request->get('creator');
        $task_name = $request->get('task');
        $task_imp = $request->get('important');
        
        if (isset($task_name)) {
            $task = new Tasks;
            $user_id = User::select('id')->where('name', $creator)->value('id');
            $task->user_id = $user_id;
            $task->creator = $creator;
            $task->task = $task_name;
            $task->important = $task_imp;
            if ($task_imp == null){ //gali buti sitas IF nereikalingas
                $task_imp = false;
            }
            $task->save();
            return redirect('main/successlogin')->with('success', 'Task successfully created!');
        } else {
            return redirect('main/successlogin')->with('error', 'Task field cannot be empty.' );
        }
        
    }

    public function destroy($id)
    {
        $task = Tasks::find($id);
        if (isset($task)){
            $task->delete();
        }
        return back()->with('success', 'Task successfully deleted!');
    }

    public function edit($id)
    {
        $task = Tasks::find($id);
        return view('edit', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'task' => 'required',
        ]);
        $task = Tasks::find($id);
        $task->task = $request->get('task');
        $task->important = $request->get('important');
        $task->save();
        return view('tasklist2')->with('success', 'Task successfully updated!');
    }

    function complete(Request $request)
    {
        $task = Tasks::find($request->get('id'));
        $task->complete = true;
        $task->save();
        return back()->with('success', 'Task successfully completed!');
    }
}
