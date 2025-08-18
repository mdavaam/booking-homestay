<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

 
class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('welcome');
        }

        if (Auth::user()->role !== 'user') {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
