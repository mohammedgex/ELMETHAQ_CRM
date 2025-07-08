<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        if ($user->role === 'admin' || $user->permissions->contains('permission', $permission)) {
            return $next($request);
        }

        abort(403, 'لا تملك صلاحية الوصول.');
    }
}
