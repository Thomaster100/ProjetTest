<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PermissionMiddleware {
    
    public function handle($request, Closure $next, $permission) {
        
        $user = Auth::user();

        if (!$user || !$user->hasPermission($permission)) {
            abort(Response::HTTP_FORBIDDEN, 'Accès refusé.');
        }

        return $next($request);
    }
}
