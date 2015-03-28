@extends("layout")
@section("content")
<div>
	<h1 style="text-align:center">Willkommen zu Planning Poker App!</h1>

	{{ Form::open(array('route' => array('user/join'), 'class' => 'form-signin', 'method' => 'post')) }}
 
 	<p>{{ Form::label('session', 'Session-ID', array('class' => 'sr-only')) }}
 	{{ Form::text('session', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Session-Name')) }}</p>
 	
 	<p>{{ Form::label('pwd', 'Session-Passwort', array('class' => 'sr-only')) }}
 	{{ Form::password('pwd', array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort')) }}</p>
 
 	<p>{{ Form::label('name', 'Eigener Nickname', array('class' => 'sr-only')) }}
 	{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Nickname')) }}</p>
 
 	<p>{{ Form::submit('Session beitreten', array('class' => 'btn btn-lg btn-danger btn-block')) }}</p>
 
	{{ Form::close() }}
</div>
@stop
