@extends("layout")
@section("content")
<div>

	{{ Form::open(array('route' => array('session/start'), 'method' => 'post')) }}
 
 	<p>{{ Form::label('session', 'Session-ID') }}
 	{{ Form::text('session') }}</p>
 	
 	<p>{{ Form::label('pwd', 'Session-Passwort') }}
 	{{ Form::password('pwd') }}</p>
 
 	<p>{{ Form::submit('Session erstellen') }}</p>
 
	{{ Form::close() }}

</div>
@stop
