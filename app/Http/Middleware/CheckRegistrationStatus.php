<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistrationStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $registrationDisabled = DB::table('settings')->where('key', 'disable_registration')->value('value') === 'true';

        if ($registrationDisabled) {
            return redirect('/')->with('error', 'Registration is currently disabled.');
        }

        return $next($request);
    }
}
