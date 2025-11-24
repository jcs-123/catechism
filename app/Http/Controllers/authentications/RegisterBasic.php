<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }
  public function register(Request $request)
  {
    // print_r("hi");
    //exit;
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6',
    ]);

    Users::create([
      'username' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return redirect('/')->with('success', 'Registration successful! Please log in.');
  }
}
