<?php

//Test Routen

Route::get("/modtest", [
	"uses" => "HomeController@showModTest"
]);
Route::get("/usertest", [
	"uses" => "HomeController@showUserTest"
]);
Route::get("/sessiontest", [
	"as" => "session/create",
	"uses" => "PPSessionController@getCreateSession"
]);

Route::get("/ppa_mod", [
	"as" => "mod/moderator",
	"uses" => "HomeController@showModTest"
]);
Route::get("/ppa_user", [
	"as" => "user/user",
	"uses" => "HomeController@showUserTest"
]);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any("/", [
	"as" => "index",
	"uses" => "HomeController@showWelcome"
]);

Route::get("/join", [
	"as" => "user/join",
	"uses" => "UserController@getjoinSession"
]);

Route::post("/join", [
	"as" => "user/join",
	"uses" => "UserController@joinSession"
]);

Route::any("/info", [
	"as" => "info",
	"uses" => "HomeController@showInfo"
]);

Route::get("/login", [
	"as" => "mod/login",
	"uses" => "ModController@getLogin"
])->before('guest');

Route::post("/login", [
	"uses" => "ModController@postLogin"
]);

Route::get("/register", [
	"as" => "mod/register",
	"uses" => "ModController@getRegister"
])->before('guest');

Route::post("/register", [
	"uses" => "ModController@postRegister"
]);

Route::any("/logout", [
	"as" => "mod/logout",
	"uses" => "ModController@logout"
])->before('auth');


Route::get("/end", [
	"as" => "user/end",
	"uses" => "UserController@showEnd"
])->before('auth');

Route::post("/end", [
	"as" => "user/logout",
	"uses" => "UserController@logout"
])->before('auth');



Route::any("/profile", [
	"as" => "mod/sessions",
	"uses" => "PPSessionController@showSessionList"
])->before('auth');

Route::get("/session/create", [
	"as" => "session/create",
	"uses" => "PPSessionController@getCreateSession"
])->before('auth');

Route::post("/session/create", [
	"as" => "session/create",
	"uses" => "PPSessionController@postCreateSession"
])->before('auth');

Route::any("/session/logout", [
	"as" => "session/logout",
	"uses" => "PPSessionController@logout"
])->before('auth');

Route::any("/session/login", [
	"as" => "session/login",
	"uses" => "PPSessionController@login"
])->before('auth');

Route::any("/profile", [
	"as" => "session/profile",
	"uses" => "PPSessionController@showSessionList"
])->before('auth');

Route::post("/session/delete", [
	"as" => "session/delete",
	"uses" => "PPSessionController@deleteSession"
]);

Route::get("/session", [
	"as" => "session/start",
	"uses" => "PPSessionController@getShowUserstories"
])->before('guest');

Route::post("/session", [
	"as" => "session/start",
	"uses" => "PPSessionController@postShowUserstories"
]);

Route::get("/pdf/{sess}", [
	"as" => "pdf",
	"uses" => "FileController@showPDF"
]);

Route::post("/pdf/{sess}", [
	"as" => "pdf",
	"uses" => "FileController@showPDF"
]);

Route::get("/link", [
	"as" => "pdf",
	"uses" => "HomeController@showLink"
]);

Latchet::connection('Connection');
Latchet::topic('sessions/{session_name}', 'SessionRoom');