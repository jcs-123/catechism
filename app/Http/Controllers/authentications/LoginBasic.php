<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
  public function login(Request $request)
  {
    $credentials = $request->only('username', 'password');
    if (Auth::attempt($credentials)) {
      return redirect()->intended('/dashboard');
    }

    return redirect('/')->with('error', 'Invalid credentials. Please try again.');
  }

  public function logout()
  {
    auth()->logout();
    return redirect('/');
  }
}
