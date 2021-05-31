<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    //Added to avoid 419 error when logging out
    public function handle($request, Closure $next)
    {
        //check that the user is a guest and the route is 'logout'
        if(!Auth::check() && $request->route()->named('logout')) {
            //add logout route to the 'except' array above
            $this->except[] = route('logout', ['lang' =>App::getLocale()]);
            
        }
        //pass control to the ccore VerifyCsrfToken middleware that now recognizes the logout route as the exception
        //and bypasses the chek
        return parent::handle($request, $next);
    }
}
