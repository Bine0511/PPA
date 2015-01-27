<?php

//Test Routen

Route::get("/modtest", [
	"uses" => "HomeController@showModTest"
]);
Route::get("/usertest", [
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
	"uses" => "SessionController@getCreateSession"
])->before('auth');

Route::post("/session", [
	"as" => "session/start",
	"uses" => "SessionController@postCreateSession"
])->before('auth');






Route::get("/pages/{page}", [
	"as" => "page",
	"uses" => "HomeController@showPage"
]);

Route::get("/pdf", [
	"as" => "pdf",
	"uses" => "FileController@showPDF"
]);