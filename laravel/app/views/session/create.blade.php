@extends("layout")
@section("content")

	{{ Form::open(array('route' => array('session/create'), 'class' => 'form-signin', 'method' => 'post')) }}
 	<h2>Session erstellen</h2>

 	{{ Form::label('session', 'Session-ID', array('class' => 'sr-only')) }}
 	{{ Form::text('session', null, array('id' => 'session', 'class' => 'form-control signin-input', 'placeholder' =>'Session-Name')) }}
 	
 	{{ Form::label('pwd', 'Session-Passwort', array('class' => 'sr-only')) }}
 	{{ Form::password('pwd', array('id' => 'password', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort')) }}
 
 	{{ Form::submit('Session erstellen', array('class' => 'btn btn-lg btn-danger btn-block')) }}
 
	{{ Form::close() }}
	

@stop
