@extends("layout")
@section("content")
	{{ Form::open() }}
	{{ $errors->first("password") }}<br />
		<!--@if (isset($error))
			{{ $error }}<br />
		@endif-->
	{{ Form::label ("username", "Username") }}
	{{ Form::text ("username", Input::old("username")) }}
	{{ Form::label ("password", "Password") }}
	{{ Form::password ("password") }}
	{{ Form::submit ("login") }}
	{{ Form::close () }}
@stop