<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;


class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Le lien de vérification est invalide.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        } else {
            return redirect()->route('login')->with('error', 'Votre email a déja été vérifié.');
        }
 
        return redirect()->route('email.verified')->with('success', 'Votre email a été vérifié.');
    }

    public function verified() {
        return view('auth.verified');
    }
}