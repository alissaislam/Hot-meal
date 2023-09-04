<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
       if(! $token = JWTAuth::parseToken())
       return response()->json(['error' => 'Unauthorized'], 401);

        $payload = $token->getPayload();
        $roleToken = $payload->get('role');
        // Check the user's role
        if ($roleToken !== $role) {
        return response()->json(['error' => 'Forbidden'], 403);
        }
        $request->userId = $payload->get('sub');
       // dd( $request->userId );
        return $next($request);
    }
}
