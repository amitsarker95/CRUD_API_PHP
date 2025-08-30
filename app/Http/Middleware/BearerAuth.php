<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use app\Models\User;

class BearerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->headers->get('Authorization');
        if(!$header || !preg_match('/Bearer\s(\S+)/', $header, $m)){
            return response()->json(['error' => 'Unauthorized token is missing !!'], 401);
        }
        $token = $m[1];

        $user = User::where('api_token', $token)->first();
        if(empty($user)){
            return response()->json(['error'=> 'Invalid Token'],401);
        }
        Auth::setUser($user);
        return $next($request);
    }
}
