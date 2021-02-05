<?php

namespace App\Http\Controllers\Branches;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = 'sucursales/cliente/';

    public function showLoginForm()
    {
        return view('Branches.Auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request){
        //Validando
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'password.min' => 'El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.'
        ]);

        //Autentificando
        if(Auth::guard('branch')->attempt([
            'email'    => $request->email,
            'password' => $request->password
        ], $request->remember)){
            //dd(Auth::check());
            return redirect()->route('branches.customer');

        }else{
            return back()->withInput($request->only('email', 'remember'))->with('error','El usuario y/o contraseña son incorrecto(s), por favor verifique sus datos.');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/sucursales/login');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
