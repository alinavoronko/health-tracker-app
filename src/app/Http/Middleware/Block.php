<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Block
{
    protected $auth;
    public function __construct(Guard $auth)

    {

        $this->auth = $auth;

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        
      

        
            $user=$this->auth->user();
            
                if($user && $user->isBlocked==1){
                 
    
            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/')->withErrors([
    
                'message' => 'This account is blocked.',
    
            ]);
    
          
        }

        return $next($request);
    }
}
