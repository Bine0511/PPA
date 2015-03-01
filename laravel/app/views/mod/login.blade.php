@extends("layout")
@section("content")
	{{ Form::open() }}
	@if (Session::has('login_errors'))
        <span class="error">Username or password incorrect.</span>
    @endif
		<!--@if (isset($error))
			{{ $error }}<br />
		@endif-->
	{{ Form::label ("name", "Username") }}
	{{ Form::text ("name", Input::old("name")) }}
	{{ Form::label ("pwd", "Password") }}
	{{ Form::text ("pwd") }}
	{{ Form::submit ("Login") }}
	{{ Form::close () }}
@stop