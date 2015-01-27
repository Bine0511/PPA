<?php

class UserController extends Controller
{
	public function getLogin() {
		return View::make("user.login");
	}

	public function postLogin(){
		$user = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );
        
        if (Auth::attempt($user)) {
            return Redirect::route('index');
        }
        
        return Redirect::route('user/login')
            ->withInput();
	}


	public function getRegister() {
		return View::make("user.register");
	}

	public function postRegister(){
		$rules = array(
			'username' => array('required', 'min:3'),
			'password' => array('required', 'min:5')
		);
		
		$messages = array(
			'password.required' => 'Password is required.',
			'password.min' => 'Your password is too short! Min. 5 symbols.',
			'username.required' => 'Username is required.',
			'username.min' => 'Your username is too short! Min. 3 letters.',
			'username.unique' => 'This username has already been taken.'
		);

		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails()) {
			return Redirect::to('register')->withInput()->withErrors($validation);	
		}

		$test = DB::insert('insert into user (username, password) values("'.Input::get('username').'", "'.Hash::make(Input::get('password')).'")');
	}

	public function logout() {
		Auth::logout();
		return Redirect::route("user/login");
	}
}