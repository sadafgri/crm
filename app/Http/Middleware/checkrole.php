<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $roles = [
            'admin'=>['admin'],
            'adminAndseller'=>['admin','seller'],
            'adminAndcustomer'=>['admin','customer']
        ];
        if(!in_array(auth()->user()->role, $roles[$role])){
            abort(code: 403);
        }
        return $next($request);
    }
}

