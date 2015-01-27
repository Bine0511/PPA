@extends("layout")
@section("content")
	{{ Form::open(array('route' => array('mod/register'), 'method' => 'post')) }}
 
 	<p>{{ Form::label('name', 'Username') }}
 	{{ Form::text('name') }}</p>
 	
 	<p>{{ Form::label('pwd', 'Password') }}
 	{{ Form::password('pwd') }}</p>
 
 	<p>{{ Form::label('pwd_confirmation', 'Password confirm') }}
 	{{ Form::password('pwd_confirmation') }}</p>
 
 	<p>{{ Form::submit('Submit') }}</p>
 
	{{ Form::close() }}
@stop