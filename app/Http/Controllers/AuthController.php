<?php

namespace App\Http\Controllers;

use App\Models\User;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller {

  public function login(Request $request) {

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Récupération utilisateur
    $user = User::where('email', $request->email)->first();

    // Vérification email
    if ($user && $user->hasVerifiedEmail()) { 

        if (Auth::attempt($credentials)) {
          $request->session()->regenerate();
          return redirect('/postList');
      }
   } else {
      return redirect()->route('login')->with('error', 'Votre email n\'a pas été vérifié.');
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
