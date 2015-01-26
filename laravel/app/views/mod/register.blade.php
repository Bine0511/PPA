@extends("layout")
@section("content")
	{{ Form::open(array('route' => array('mod/register'), 'method' => 'post')) }}
 
 	<p>{{ Form::label('name', 'Username') }}
 	{{ Form::text('name') }}</p>
 	
 	<p>{{ Form::label('pwd', 'Password') }}
 	{{ Form::text('pwd') }}</p>
 
 	<p>{{ Form::label('pwd_confirmation', 'Password confirm') }}
 	{{ Form::text('pwd_confirmation') }}</p>
 
 	<p>{{ Form::submit('Submit') }}</p>
 
	{{ Form::close() }}
@stop