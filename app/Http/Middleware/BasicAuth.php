<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user     = env('BASIC_AUTH_USERNAME', '');
        $password = env('BASIC_AUTH_PASSWORD', '');

        if (
            $request->getUser() !== $user ||
            $request->getPassword() !== $password
        ) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Admin"',
            ]);
        }

        return $next($request);
    }
}
