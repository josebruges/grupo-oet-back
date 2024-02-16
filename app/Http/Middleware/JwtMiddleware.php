<?php

namespace App\Http\Middleware;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Closure;
use Exception;

use Illuminate\Http\Request;

class JwtMiddleware
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
        $token = $request->header("Authorization");
        if (!$token) {
            return response()->json(["error" => "token no proporcionado"], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'El token proporcionado ha caducado.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Ha ocurrido un error al decodificar el token.'
            ], 400);
        }

        $user = User::find($credentials->id);
        $request->userCorrecto = $user;

        return $next($request);
    }

    }