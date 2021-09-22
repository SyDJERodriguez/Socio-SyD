<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = 'admin/customers/';

	public function showLoginForm(){
		return view('Admin.Auth.login');
	}

    public function showRegisterForm()
    {
        return view('auth.register');
    }

	public function login(Request $request){
        $is_register = DB::table('admins')
            ->select('email')
            ->where('email', '=', $request->email)
            ->first();

        if ($is_register === null){
            return back()->withInput($request->only('email'))->with('register','');
        }

        //Validando
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],[
            'password.min' => 'La contraseña es incorrecta, por favor verifique sus datos'
        ]);

		//Autentificando
		if(Auth::guard('admin')->attempt([
			'email'    => $request->email,
			'password' => $request->password
		], $request->remember)){
            //dd(Auth::check());
            
			return redirect()->route('admin.insertLog');

		}

        return back()->withInput($request->only('email'))->with('error','La contraseña es incorrecta');
	}

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/admin/login/');
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard();
    }


}
