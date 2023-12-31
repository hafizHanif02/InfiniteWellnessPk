<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($request->user()->hasRole('Admin')) {
                    return redirect('dashboard');
                }
                if ($request->user()->hasRole('Receptionist|Case Manager')) {
                    return redirect('notice-boards');
                }

                return redirect('/dashboard');

                // return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
