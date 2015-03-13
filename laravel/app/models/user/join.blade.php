@extends("layout")
@section("content")
<div>
	<h1>Willkommen zu Planning Poker App!</h1>

	@if (Auth::Mod()->check())
		<a href="{{ URL::route('session/create') }}">Session erstellen</a>
	@endif

	{{ Form::open(array('route' => array('user/join'), 'method' => 'post')) }}
 
 	<p>{{ Form::label('session', 'Session-ID') }}
 	{{ Form::text('session') }}</p>
 	
 	<p>{{ Form::label('pwd', 'Session-Passwort') }}
 	{{ Form::password('pwd') }}</p>
 
 	<p>{{ Form::label('name', 'Eigener Nickname') }}
 	{{ Form::password('name') }}</p>
 
 	<p>{{ Form::submit('Session beitreten') }}</p>
 
	{{ Form::close() }}
</div>
@stop
