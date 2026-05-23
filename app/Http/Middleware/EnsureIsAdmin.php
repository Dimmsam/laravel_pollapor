<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Hanya izinkan user dengan role admin_jurusan atau kajur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, ['admin', 'kajur'])) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return redirect()->route('login')
                ->withErrors(['email' => 'Anda tidak memiliki akses.']);
        }

        return $next($request);
    }
}
