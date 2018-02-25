<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{

    public function login()
    {
        Auth::logout();
        return view('auth/login');
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function authenticate(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user_id = DB::table('users')->where('email', $username)->first();
        dd($user_id);


    }
}