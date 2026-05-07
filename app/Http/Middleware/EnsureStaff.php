<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user() ?: Auth::guard('staff')->user();

        abort_unless($user && in_array($user->role ?? null, ['admin', 'staff'], true), 403);

        return $next($request);
    }
}
