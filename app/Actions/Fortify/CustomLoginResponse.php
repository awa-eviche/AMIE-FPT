<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class CustomLoginResponse implements LoginResponseContract
{
    /**
     * Retourne la réponse de connexion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = $request->user();

        // Si l'utilisateur a le rôle "dage", le rediriger vers le flux SSO (IdP-initié)
        if ($user && $user->hasRole('dage')) {
            return redirect()->intended('/auto-redirect-sso');
        }

        // Sinon, rester sur AMI‑FPT (rediriger vers le dashboard local sur le domaine 8001)
        return redirect()->intended('/dashboard');
    }
}
