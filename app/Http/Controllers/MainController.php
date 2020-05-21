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

    /*public function __construct()
    {
        $this->middleware('auth');
    }*/


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

        $exists = User::where('name', $request['name'])->get();
        if (($bool == true) && (count($exists) == 0)) 
        {
            User::create([
                'name' => $request['name'],
                'password' => Hash::make($request['password']),
            ]);
            return back()->with('success', 'Successfully registered!');
        }
        else
        {
            return back()->with('error2', 'This user name already exists.');
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
}
