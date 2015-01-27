<?php

class SessionController extends Controller
{
	public function getLogin() {
		return View::make("mod/login");
	}

	public function postLogin(){

		$mod = array(
            'moderator_name' => Input::get('name'),
            'password' => Input::get('pwd')
        );
        
        if (Auth::attempt($mod)) {
            return Redirect::route('index');
        }

        return Redirect::route('mod/login')
            ->withInput()
            ->with('login_errors', true);
	}


	public function getCreateSession() {
		return View::make("session");
	}

	public function postCreateSession(){

		$cred = array(
            'session_name' => Input::get('name'),
            'session_id' => Hash::make(Input::get('pwd')),
            'session_moderator_id' => Auth::user()->username
        );

        $newSession = Session::create($cred);
        if($newSession){
            return Redirect::route('session/{sess_id}');
        }

        return Redirect::to('session')->withInput()->withErrors($validation);
	}
}