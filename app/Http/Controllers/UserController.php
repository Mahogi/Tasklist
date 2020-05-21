<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function changePass(Request $request)
    {
        $user = User::find($request->get('user'));
        return view('changepass', ['user' => $user]);
    }

    function editPass(Request $request)
    {
        $bool = $this->validate($request, [
            'oldpassword' => 'required|AlphaNum|min:4',
            'newpassword1' => 'required|AlphaNum|min:4',
            'newpassword2' => 'required|AlphaNum|min:4'
        ]);
        if ($bool)
        {
            $username = $request->get('user');
            $user = User::where('name', $username)->first();
            if (Hash::check($request->get('oldpassword'), $user->password)) 
            {
                if ((strcmp($request->get('newpassword1'), $request->get('newpassword2'))) == 0)
                {
                    $newpassword = Hash::make($request->get('newpassword1'));
                    $user->password = $newpassword;
                    $user->save();
                    return redirect('main/successlogin')->with('success', 'Password successfully changed!'); 
                }
                else 
                {
                    return back()->with('error', 'New passwords must match!');
                }
                
            }
            else
            {
                return back()->with('error', 'Wrong password!');
            }
        }
    }

    function deleteAccount(Request $request)
    {
        if (($request->session()->get('user')) != null)
        {
            $user = User::where('name', $request->get('creator'));
            $user->delete();
            $request->session()->flush();
            return redirect('main');
        }
        else
        {
            return redirect('main');
        }
        
    }
}
