<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
    
class AdminAuthenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user()?? '';

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Please Login And Try Again!']);
        } elseif (!$user->is_admin) {
            abort(403, 'You are not have permission to access this page');
        }
        return $next($request);
    }
}
