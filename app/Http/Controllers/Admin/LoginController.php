<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/customers/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function showLoginForm(){
		return view('Admin.Auth.login');
	}

    public function showRegisterForm()
    {
        return view('auth.register');
    }

	public function login(Request $request){
		//Validando
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|min:6'
		]);

		//Autentificando
		if(Auth::guard('admin')->attempt([
			'email'    => $request->email,
			'password' => $request->password
		], $request->remember)){

			return redirect()->route('admin.customers.index');

		}

		return redirect()->back()->withInput($request->only('email', 'remember'))->with('error','Usuario y contraseña inválido');
	}


}
