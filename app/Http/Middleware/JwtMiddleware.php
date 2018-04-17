<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Response;
use App\Http\Controllers\AuthController;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Cookie;

class JwtMiddleware
{
    private $response;
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->cookie('access-token');
        $ref_token = $request->cookie('refresh-token');
        if(!$token) {
            // Unauthorized response if token not there
            return redirect('/login');
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            try {
            $credentials_r = JWT::decode($ref_token, env('JWT_SECRET'), ['HS256']);
        }   catch(ExpiredException $e){return redirect('/login');}
        $user = User::find($credentials_r->sub);
        $request->auth = $user;
        $response=$next($request);
        return AuthController::refreshtoken($response,$user);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
                $user = User::find($credentials->sub);
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        $response=$next($request);
        if (!$ref_token) {
        return AuthController::refreshtoken($response,$user);
        }
        return $response;
    }
}