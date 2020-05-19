<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    function index()
    {
        $users = User::all();
        return view('login', ['users' => $users]);
    }

    function checklogin(Request $request)
    {
        $user_data = array (
            'name' => $request->get('name'),
            'password' => $request->get('password')    
        );
        if (Auth::attempt($user_data))
        {
            $request->session()->put('user', $user_data['name']);
            return view('tasklist2');
        }
        else 
        {
            return back()->with('error1', 'Wrong login details!');
        }
    }

    function register(Request $request)
    {
        $bool = $this->validate($request, [
            'name' => 'required',
            'password' => 'required|AlphaNum|min:4'
        ]);

        if ($bool == true) 
        {
            User::create([
                'name' => $request['name'],
                'password' => Hash::make($request['password']),
            ]);
            return back()->with('success', 'Successfully registered!');
        }
    }

    function successlogin()
    {
        return view('tasklist2');
    }

    function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('main');
    }

    function create(Request $request)
    {
        $creator = $request->get('creator');
        $task_name = $request->get('task');
        $task_imp = $request->get('important');
        
        if (isset($task_name)) {
            $task = new Tasks;
            $task->creator = $creator;
            $task->task = $task_name;
            $task->important = $task_imp;
            if ($task_imp == null){ //gali buti sitas IF nereikalingas
                $task_imp = false;
            }
            $task->save();
            return back()->with('success', 'Task successfully created!');
        } else {
            return back()->with('error', 'Task field cannot be empty.' );
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

    //public function show()
    //{

   // }
}
