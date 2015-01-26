@extends("layout")
@section("content")
	{{ Form::open() }}
	{{ $errors->first("pwd") }}<br />
		<!--@if (isset($error))
			{{ $error }}<br />
		@endif-->
	{{ Form::label ("name", "Username") }}
	{{ Form::text ("name", Input::old("name")) }}
	{{ Form::label ("pwd", "Password") }}
	{{ Form::password ("pwd") }}
	{{ Form::submit ("Login") }}
	{{ Form::close () }}
@stop