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

	public function showWelcome()
	{
		return View::make('hello');
	}

		public function showRegal()
	{
		$books = Book::where('id', '>', 0)->get();
		return View::make('books', array('books' => $books));
	}


	public function showNewBook(){
		return View::make('newBook');
	}

	public function createNewBook(){
		$book = new Book();
		$book->Titel = Input::get("titel");
		$book->User = Input::get("user_ID");
		$book->save();

		return View::make('createBook');
	}

	public function updateBook(){
		return View::make('update');
	}

	public function updateNewBook(){
		$book = Book::where('ID', '=', Input::get("id"))->get();
		$book->Inhalt = Input::get("inhalt");
		$book->save();
		return View::make('updateNew');
	}


}