<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('client.pages.auth.login');
    }
    public function registerView()
    {
        return view('client.pages.auth.register');
    }
    public function fogetPasswordView()
    {
        return view('client.pages.auth.foget-password');
    }
}
