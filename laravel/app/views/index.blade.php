@extends("layout")
@section("content")
	{{ Form::open(array('route' => array('mod/register'),'class' => 'form-signin' ,'method' => 'post')) }}
	<h2 class="form-signin-heading">Einer Session beitreten</h2>
 	{{ Form::label('session', 'Session-ID', array('class' => 'sr-only')); }}
	{{ Form::text('session', null, array('id' => 'session', 'class' => 'form-control signin-input', 'placeholder' =>'Session-ID')); }}

	{{ Form::label('pwd', 'Session-Passwort', array('class' => 'sr-only')); }}
	{{ Form::password('pwd', array('id' => 'pwd', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort')); }}

	{{ Form::label('name', 'Eigener Nickname', array('class' => 'sr-only')); }}
	{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Nickname'));}}
	{{ Form::submit('Session beitreten', array('class' => 'btn btn-lg btn-danger btn-block')); }}
 
	{{ Form::close() }}
@stop
