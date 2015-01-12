<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome(){
		return View::make('index');
	}

	public function showLoad(){
		return View::make('load');
	}

	public function showPage($book){
		$bookdata = DB::select('select * from books where book_ID = "'.$book.'"');
		$user = DB::select('select username from users where id ="'.$bookdata[0]->user_ID.'"');
		$chapters = DB::select('select * from chapters where book_ID = "'.$book.'"');
		$bookinfo = array('title' => $bookdata[0]->title, 'book_id' => $bookdata[0]->book_ID, 'user' => $user[0]->username);
		return View::make("books/book", array('bookdata' => $bookinfo), array('chapters' => $chapters));
	}
}
