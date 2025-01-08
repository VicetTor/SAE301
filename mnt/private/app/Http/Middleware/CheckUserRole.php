<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole {
    public function handle(Request $request, Closure $next, $role) {
        $user = auth()->user();

        if ($role == 'responsable_formation' && $user->type_id != 4) {
            abort(403, "Vous n'avez pas l'autorisation d'accéder à cette page.");
        }

        return $next($request);
    }
}
