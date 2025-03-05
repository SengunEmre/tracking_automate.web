<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $validUsername = 'admin'; // Set your username
        $validPassword = 'mypassword123'; // Set your password

        if ($request->session()->has('authenticated')) {
            return $next($request);
        }

        if ($request->input('username') === $validUsername && $request->input('password') === $validPassword) {
            $request->session()->put('authenticated', true);
            return redirect()->to('/');
        }

        return response()->view('auth.simple-login');
    }
}
