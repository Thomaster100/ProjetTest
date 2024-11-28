<?php

namespace App\Http\Controllers;

use App\Models\User;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {

  public function login(Request $request) {

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect('/postList');
    }

    return back()->withErrors([
        'email' => 'Les identifiants fournis sont incorrects.',
    ]);
  }

  public function showLoginForm() {
    return view('auth.login');
}

  public function logout(Request $request) {
    
    Auth::logout();
    // auth()->logout(); avec le middleware web
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}
