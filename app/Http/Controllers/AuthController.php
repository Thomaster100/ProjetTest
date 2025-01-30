<?php

namespace App\Http\Controllers;

use App\Models\User;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password; // A ajouter !! 
use Illuminate\Support\Str; // A ajouter si besoin d'une classe String
use Illuminate\Auth\Events\PasswordReset;

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

  public function showForgotPasswordForm() {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Un email de réinitialisation a été envoyé.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token, $email) {
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request) {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        /*
         Qu'est ce que la classe Password ? *
         Classe qui gère la réinitialisation des mot de passe
        */

        $status = Password::reset(

            // $request->only -> Récupère uniquement les champs désirés
            $request->only('email', 'password', 'password_confirmation', 'token'),

            // Utilisation d'une boucle foreach avec closure (callback)
            function ($user) use ($request) {
                $user->forceFill([ // forceFill -> force les attributs sans passer par l'assignation en masse de tout les attributs (name, email...)
                    'password' => bcrypt($request->password),
                ])->setRememberToken(Str::random(60)); // met à jour le remember token, utilisé pour le mécanisme "Se souvenir de moi" (remember me).

                $user->save();

                event(new PasswordReset($user)); // Evénement PasswordReset pour indiquer que le mot de passe a bien réinitialisé pour l'utilisateur.
            }
        );

        return $status === Password::PASSWORD_RESET 
            // $status -> Retour de la méthode Password::reset(...) 
            // Password::PASSWORD_RESET -> Constante pour dire que le la reinitialisation a marché
            // il en existe d'autres.. Exemple : Password::INVALID_USER si l'utilisateur n'a pas été trouvé
            ? redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé.')
            : back()->withErrors(['email' => [__($status)]]);
    }

}
