<?php

namespace App\Http\Middleware;


use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Route;

class Authenticate extends Middleware
{


    protected function redirectTo($request)
	 {
		 if (! $request->expectsJson()) {
             if(Route::is('admin.*')){
                 return route('admin.login');
             }
             if(Route::is('branches.*')){
                 return route('branches.login');
             }
			 //return route('login'); //add redirect to guest
			// return route('admin.login');
		 }
	 }


    /*protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }


        $guard = array_get($exception->guards(),0);

        switch ($guard){
            case 'admin':
                $login = 'admin.login';
                break;
            default:
                $login = 'login';
                break;
        }

        return redirect()->guest(route($login));
    }*/
}
