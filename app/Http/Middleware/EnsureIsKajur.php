<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsKajur
{
    /**
     * Hanya izinkan user dengan role kajur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== 'kajur') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized — Khusus Kajur'], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', 'Halaman ini hanya dapat diakses oleh Kepala Jurusan.');
        }

        return $next($request);
    }
}
