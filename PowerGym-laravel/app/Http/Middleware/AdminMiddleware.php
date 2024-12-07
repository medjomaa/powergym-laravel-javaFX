<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function isAdmin() {
        $user = Auth::user();
        return $user->role == 'admin';
    }
    public function handle($request, Closure $next)
    {
        if ($this->isAdmin()) {
            return $next($request);
        }

        return redirect('/');
    }
}
