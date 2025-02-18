<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    // Redirection vers le fournisseur OAuth
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    // Callback après la connexion réussie
    public function callback($provider)
    {
        try {

            $socialUser = Socialite::driver($provider)->user();

            // Vérifier si l'utilisateur existe déjà
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {

                // redirection vers votre page préférée...
                // Inscription d'un nouvel utilisateur
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make("password"), // Mot de passe de test
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);

            } else {
                // Si l'utilisateur existe déjà, on met à jour ses infos
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }

            // Connexion de l'utilisateur
            Auth::login($user);

            return redirect('/postList')->with('success', "Bienvenue, {$user->name} !");

        } catch (\Exception $e) {

            return redirect('/login')->with('error', "Erreur de connexion avec $provider !");
        }
    }
}
