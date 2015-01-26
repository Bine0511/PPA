<?php

class ModController extends Controller
{
	public function getLogin() {
		return View::make("mod/login");
	}

	public function postLogin(){
		$user = array(
            'moderator_name' => Input::get('name'),
            'moderator_pw' => Input::get('pwd')
        );
        
        if (Auth::attempt($user)) {
            return Redirect::route('index');
        }
        
        return Redirect::route('mod/login')
            ->withInput();
	}


	public function getRegister() {
		return View::make("mod.register");
	}

	public function postRegister(){
		$rules = array(
			'name' => array('required', 'min:3'),
			'pwd' => array('required', 'min:5')
		);
		
		$messages = array(
			'pwd.required' => 'Password is required.',
			'pwd.min' => 'Your Password is too short! Min. 5 symbols.',
			'name.required' => 'Username is required.',
			'name.min' => 'Your Username is too short! Min. 3 letters.',
			'name.unique' => 'This Username has already been taken.'
		);

		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails()) {
			return Redirect::to('register')->withInput()->withErrors($validation);	
		}

		$test = DB::insert('insert into moderator (moderator_name, moderator_pw) values("'.Input::get('name').'", "'.Hash::make(Input::get('pwd')).'")');
	}

	public function logout() {
		Auth::logout();
		return Redirect::route("mod/login");
	}
}