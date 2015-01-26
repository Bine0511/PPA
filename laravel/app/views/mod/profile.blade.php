@extends("layout")
@section("content")
	<h2>Hello {{ Auth::user()->username }}!</h2>
	<p>How are you today?</p>
	<div class="regal">
	@foreach ($myBooks as $myBook)
		<a href="{{ URL::route('books/book', array('book' => $myBook->book_ID)) }}"class="book"><p><span class="title">{{ $myBook->title }}</span><br>{{ Auth::user()->username }}</p><hr class="gl1"><hr></a>
	@endforeach
	</div>
	<br>
	<div class="regal">
	@foreach ($bookmarks as $bookmark)
	<?php $book = DB::select('select * from books where book_ID = '.$bookmark->book_ID)[0];
		  $username = DB::select('select username from users where id = '.$bookmark->user_ID)[0]; ?>
		<a href="{{ URL::route('books/book', array('book' => $bookmark->book_ID)).'#'.$bookmark->chapter_ID }}"class="book egg"><p><span class="title">{{ $book->title }}</span><br>{{ $username->username }}</p></a>
	@endforeach
	</div>
@stop