<?php

class PPSessionController extends Controller
{
    public function getCreateSession() {
        return View::make("session/create");
    }

    public function postCreateSession(){
        $cred = array(
            'session_name' => Input::get('session'),
            'session_pw' => Hash::make(Input::get('pwd')),
            'session_moderator_ID' => Auth::Mod()->get()->moderator_ID
        );

        $newSession = PPSession::create($cred);
        if($newSession){
            $sessions = DB::select('select * from session where session_moderator_ID = "'.Auth::Mod()->get()->moderator_ID.'"');
            return View::make('mod/sessions', array('sessions' => $sessions));
        }

        return Redirect::to('session/create')->withInput();
    }


    public function logout() {
        Auth::PPSession()->logout();
        $sessions = DB::select('select * from session where session_moderator_ID = "'.Auth::Mod()->get()->moderator_ID.'"');
        return Redirect::route('mod/sessions', array('sessions' => $sessions));
    }

    public function login() {
        if(Auth::PPSession()->loginUsingId(Input::get('session_ID'))){
            $userstories = DB::select('select * from userstory where userstory_session_ID = "'.Auth::PPSession()->get()->session_ID.'"');
            return Redirect::route('session/start');
        }
    }

    public function getShowUserstories(){
            $basestory = DB::select('select session_basestory_id from session where session_ID = "'.Auth::PPSession()->get()->session_ID.'"');
            $userstories = DB::select('select * from userstory where userstory_session_ID = "'.Auth::PPSession()->get()->session_ID.'"');
            return View::make('session/start', array('userstories' => $userstories, 'basestory' => $basestory[0]));
    }

    public function postShowUserstories(){

        if(Input::get('userstory') != null){
            DB::insert("insert into userstory (userstory_session_ID, userstory_name, userstory_description) values ('".Auth::PPSession()->get()->session_ID."', '".Input::get('userstory')."', '".Input::get('description')."')");
        }
        if(Input::get('basestory') != null){
            DB::update("update session set session_basestory_id = '".Input::get('basestory')."' where session_ID = '".Auth::PPSession()->get()->session_ID."'");
        }
        if(Input::get('deleteStory') != null){
            DB::delete("delete from userstory where userstory_ID = '".Input::get('deleteStory')."'");
        }
        $basestory = DB::select('select session_basestory_id from session where session_ID = "'.Auth::PPSession()->get()->session_ID.'"');
        $userstories = DB::select('select * from userstory where userstory_session_ID = "'.Auth::PPSession()->get()->session_ID.'"');
        return View::make('session/start', array('userstories' => $userstories, 'basestory' => $basestory[0]));
    }

    public function showSessionList(){
        $sessions = DB::select('select * from session where session_moderator_ID = "'.Auth::Mod()->get()->moderator_ID.'"');
        return View::make('mod/sessions', array('sessions' => $sessions));
    }
}