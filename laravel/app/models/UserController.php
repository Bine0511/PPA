<?php

class UserController extends Controller
{

	public function joinSession(){
		$session_ID = DB::select("select session_ID from session where session_name = '".Input::get('session')."'")[0]->session_ID;
		$user = array(
            'user_name' => Input::get('name'),
            'user_session_ID' => $session_ID,
            'user_session_pw' => Input::get('pwd')
        );
        $newUser = User::create($user);
        if($newUser){
            Auth::User()->login($newUser);
            echo("WOOOOOOOOOO ES FUNKTIONIEERRRRTTT");
            //return Redirect::route('index');
        }
	}

	public function getjoinSession(){
        return View::make('user/join');
	}
}