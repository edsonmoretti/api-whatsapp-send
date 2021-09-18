<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    public function login()
    {
        return view('admin.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.dashboard'));
    }

    public function auth(Request $request)
    {
        function soNumero($str)
        {
            return preg_replace("/[^0-9]/", "", $str);
        }

        $credentials = [
            'cpf' => soNumero($request->cpf),
            'password' => $request->password
        ];
        $remember = isset($request->remember);
        Auth::attempt($credentials, $remember);
        return redirect(route('admin.dashboard'));
    }

}

