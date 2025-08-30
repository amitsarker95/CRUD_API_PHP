<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles = null): Response
    {
        $allowed = $roles ? explode(",", $roles) : [];
        $user = Auth::user();
        if (!$user){
            return response()->json(['error' => 'Invalid User!! Unauthorized'], 401);
        }

        if(!in_array($user->role, $allowed)){
            return response()->json(['message'=> 'Forbidden - insufficient role'],403);
        }
        

        return $next($request);
    }
}
