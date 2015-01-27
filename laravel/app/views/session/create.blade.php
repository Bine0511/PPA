@extends("layout")
@section("content")
<div>
	<h1>Willkommen zu Planning Poker App!</h1>

	<a href="{{ URL::route('session/start') }}">Session erstellen</a>

	{{ Form::open(array('route' => array('mod/register'), 'method' => 'post')) }}
 
 	<p>{{ Form::label('session', 'Session-ID') }}
 	{{ Form::text('session') }}</p>
 	
 	<p>{{ Form::label('pwd', 'Session-Passwort') }}
 	{{ Form::password('pwd') }}</p>
 
 	<p>{{ Form::label('name', 'Eigener Nickname') }}
 	{{ Form::password('name') }}</p>
 
 	<p>{{ Form::submit('Session beitreten') }}</p>
 
	{{ Form::close() }}

	<a href="#">Über Planning Poker App</a>
	<a href="#">Wie funktioniert Planning Poker?</a>
</div>
@stop
