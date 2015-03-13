<?php

class PPSessionController extends Controller
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
        return View::make("session/create");
    }

    public function postCreateSession(){

        $cred = array(
            'session_name' => Input::get('session'),
            'session_pw' => Hash::make(Input::get('pwd')),
            'session_moderator_id' => Auth::Mod()->get()->id
        );
        $newSession = PPSession::create($cred);
        if($newSession){
            if(Auth::PPSession()->attempt($cred)){
                return View::make('session/start');
            }
        }

        return Redirect::to('session/create')->withInput()->withErrors($validation);
    }


    public function showSession($id){
        return View::make('session/start', array('session_id' => $id));
    }

    public function postSession(){
        $userstories = DB::select('select * from userstory where userstory_session_ID = "'.Auth::PPSession()->get()->session_ID.'"');
        return View::make('session/start', array('userstories' => $userstories));
    }
}