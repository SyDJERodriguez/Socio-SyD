<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 19/09/19
 * Time: 11:28
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class HomeController extends Controller {

	public function index(){
		return view('Admin.Home.home');
	}
}