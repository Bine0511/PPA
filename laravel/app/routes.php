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


Route::get("/session", [
	"as" => "session/create",
	"uses" => "PPSessionController@getCreateSession"
])->before('auth');

Route::post("/session", [
	"as" => "session/create",
	"uses" => "PPSessionController@postCreateSession"
])->before('auth');

Route::get("/session/start", [
	"as" => "session/start",
	"uses" => "PPSessionController@showSession"
])->before('guest');

Route::post("/session/start", [
	"as" => "session/start",
	"uses" => "PPSessionController@postSession"
]);




Route::get("/pages/{page}", [
	"as" => "page",
	"uses" => "HomeController@showPage"
]);

Route::get("/pdf/{sess}", [
	"as" => "pdf",
	"uses" => "FileController@showPDF"
]);

Latchet::connection('Connection');
Latchet::topic('sessions/{session_name}', 'SessionRoom');