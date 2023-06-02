<?php

namespace App\Http\Middleware;

use App\User;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        
        if(User::find(Auth::id())->rank != $role) {
            
            return redirect()->back()->with('danger', 'You\'re not allowed here...');
            
        }
        
        return $next($request);
    }
}
