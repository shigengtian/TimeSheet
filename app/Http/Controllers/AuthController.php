<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        Auth::logout();
        return redirect()->intended('/');
    }

    public function authenticate(Request $request)
    {
        $email = $request->username;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password,'active' => 1])) {
            return redirect()->intended('home');
        } else {
            return redirect()->intended('/');
        }
    }
}