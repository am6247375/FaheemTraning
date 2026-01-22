<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Illuminate\Support\Facades\Session;

class Instructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && auth()->user()->role == 'instructor') {
            if (auth()->user()->status == 1) {
                return $next($request);
            }
            Session::flash('error', get_phrase('You cannot access the control panel. Your account is under review.'));
            return redirect()->back();
        } else {
            return redirect(route('login'));
        }
    }
}
