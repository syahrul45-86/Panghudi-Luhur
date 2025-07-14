<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if($request->user()->role === $role){
            return $next($request);
        }

        return redirect('/');
    }
    protected function defaultRedirectUri(?string $guard): string
{
    $routes = [
        'admin' => 'admin.dashboard',
        'web' => 'dashboard',
    ];

    if (array_key_exists($guard, $routes)) {
        $routeName = $routes[$guard];
        if (Route::has($routeName)) {
            return route($routeName);
        }
    }

    // Jika tidak ada guard yang cocok, arahkan ke halaman root
    return '/';
}

}
