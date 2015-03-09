<?php

class HomeController extends BaseController {


	// Tests

	public function showModTest(){
		return View::make('mod/moderator');
	}
	public function showUserTest(){
		return View::make('user/user');
	}

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome(){
		return View::make('index');
	}
	public function showInfo(){
		return View::make('info');
	}

	public function showLink(){
		return View::make('link');
	}

}
