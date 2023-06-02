<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $sessionLocale = $request->session()->get('locale');
        
        if(Auth::check()) {
            
            $currentUser = \App\User::find(Auth::id());
            
            if(isset($sessionLocale) && isset($currentUser->locale) && $currentUser->locale != $sessionLocale) {
                
                $currentUser->locale = $sessionLocale;
                $currentUser->save();
                
            } else {
                
                if(!isset($sessionLocale) && isset($currentUser->locale)) {
                    
                    $request->session()->put('locale', $currentUser->locale);
                    $sessionLocale = $currentUser->locale;
                    
                } else if(isset($sessionLocale) && !isset($currentUser->locale)) {
                    
                    $currentUser->locale = $sessionLocale;
                    $currentUser->save();
                    
                } else {
                    
                    // fall back to English?
                    
                }
                
            }
            
        }
        
        App::setLocale($sessionLocale);
        
        return $next($request);
    }
}
