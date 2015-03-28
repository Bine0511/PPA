<?php

class ModController extends Controller
{
    public function getLogin() {
        return View::make("mod/login");
    }

    public function postLogin(){

        $mod = array(
            'moderator_name' => Input::get('name'),
            'password' => Input::get('pwd')
        );
        
        if (Auth::Mod()->attempt($mod)) {
            return Redirect::route('index');
        }
        return Redirect::route('mod/login')
            ->withInput()
            ->with('login_errors', true);
    }


    public function getRegister() {
        return View::make("mod/register");
    }

    public function postRegister(){

        $mod = array(
            'moderator_name' => Input::get('name'),
            'moderator_pw' => Hash::make(Input::get('pwd'))
        );

        $newMod = Mod::create($mod);
        if($newMod){
            Auth::Mod()->login($newMod);
            return Redirect::route('index');
        }
        return Redirect::to('register')->withInput();
    }

    public function logout() {
        Auth::Mod()->logout();
        return Redirect::route("mod/login");
    }
}