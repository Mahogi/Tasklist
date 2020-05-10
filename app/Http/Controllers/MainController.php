<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
//use Illuminate\Support\Facades\Auth;
use App\User;

class MainController extends Controller
{
    public $statusas = null;
    function index(Request $request)
    {
        $users = User::all();
        $statusas = $request->input('statusas');
        if (!isset($statusas)){
            $statusas = "";
        }
        return view('login', ['statusas' => $statusas, 'users' => $users]);
    }

    function checklogin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required|AlphaNum|min:4'
        ]);

        /*$user_data = array (
            'name' => $request->get('name'),
            'password' => $request->get('password')
        );
        $user_data = $request->only('name', 'password');*/

        $user_name = $request->get('name');
        $user_pass = $request->get('password');
        $db = "tasklist";

        $connection = mysqli_connect("localhost", "root", "", $db);
        $query = "SELECT * FROM users WHERE name='$user_name' AND password='$user_pass'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result)==1)
        {
            session_start();
            $_SESSION['tasklist']='true';
            $_SESSION['user']=$user_name;
            return redirect('main/successlogin');
        }
        else
        {
            return back()->with('error', 'Wrong login details!');
        }

        /*if(Auth::attempt($user_data)){
            return redirect('main/successlogin');
        } else {
            return back()->with('error', 'Wrong login details!');
        }*/

    }

    function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required|AlphaNum|min:4'
        ]);

        if (!isset($request->name) || !isset($request->password)) 
        {
            return redirect()->action('MainController@index', ['statusas' => 1 ]);//'Visi laukai privalomi'
        }

        $db = "tasklist";
        $connection = mysqli_connect("localhost", "root", "", $db);
        $query = "SELECT * FROM users WHERE name='$request->name'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result)==1)
        {
            return back()->with('error', 'This username already exists.');
        }
        else
        {
            $user = new User;
            $user->name = $request->name;
            $user->password = $request->password;
            $user->save();
            return redirect()->action('MainController@index', ['statusas' => 2 ]);
        }

        
    }

    function successlogin()
    {
        return view('tasklist');
    }

    function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        return redirect('main');
    }

    function addTask(Request $request)
    {
        session_start();
        $creator = $request->get('creator');
        $task_name = $request->get('task');
        $task_imp = $request->get('important');

        $connection = mysqli_connect("localhost", "root", "", "tasklist");
        if ($connection->connect_error){
            die("Connection failed: " . $connection->connect_error);
        }
        
        if ($task_imp == null){
            $task_imp = 0;
        } 

        $sql = "INSERT INTO tasklist (creator, task, important) VALUES ('$creator', '$task_name', '$task_imp')";
        if ($connection->query($sql) === TRUE) {
            $_SESSION["flash"] = "New entry was created successfully!";
            return back();
        } else {
            $_SESSION["flash"] = 'Error: ' . $sql . "<br>" . $connection->error;
            return back();
        }
    }

    function deleteTask(Request $request)
    {
        session_start();
            
        $id = $request->get('id');
        if (isset($id)){
            $connection = mysqli_connect("localhost", "root", "", "tasklist");
            $sql = "DELETE FROM tasklist WHERE id='$id'";
            if ($connection->query($sql) === TRUE) {
                $_SESSION["flash"] = "New entry was deleted successfully!";
                mysqli_close($connection);
                return back();
            } else {
                $_SESSION["flash"] = 'Error: ' . $sql . "<br>" . $connection->error;
                return back();
            }       
        }
    }

    function editTask(Request $request)
    {
        $id = $request->get('id');
        $task = $request->get('task');
        $important = $request->get('important');
        $data['id'] = $id;
        $data['task'] = $task;
        $data['important'] = $important;
        return view('edit', $data);
    }

    function dbEdit(Request $request)
    {
        session_start();
        $id = $request->get('id');
        $task = $request->get('task');
        $important = $request->get('important');
        $connection = mysqli_connect("localhost", "root", "", "tasklist");
        $sql = "UPDATE tasklist SET task='$task', important='$important' WHERE id='$id'";
        $_SESSION["flash"] = "Entry was changed successfully!";
        if ($connection->query($sql) === TRUE) {
            $_SESSION["flash"] = "Entry was changed successfully!" . "_" . $id . "_" . $task . "_" . $important;
            mysqli_close($connection);
            //return view('tasklist');
            return redirect('main/successlogin'); //
        } else {
            $_SESSION["flash"] = 'Error: ' . $sql . "<br>" . $connection->error;
            return redirect('main/successlogin');
            //return view('tasklist');
        }  
    }
}
