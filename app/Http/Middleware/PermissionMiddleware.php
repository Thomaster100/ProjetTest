<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware {
    
    public function handle($request, Closure $next, $permission) {
        
        $user = Auth::user();

        if (!$user || ($permission === 'modify-todos' &&  !$user->hasPermission($permission))) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
