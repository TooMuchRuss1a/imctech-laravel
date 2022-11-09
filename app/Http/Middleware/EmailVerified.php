<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->hasVerifiedEmail()) {
            if ($redirect_to = Cookie::get('redirect_to')) {
                Cookie::queue(Cookie::forget('redirect_to'));

                return redirect($redirect_to);
            }

            return $next($request);
        }

        return redirect()->route('verification.notice');
    }
}
