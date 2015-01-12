@extends("layout")
@section("content")
	{{ Form::open() }}
 
 	<p>{{ Form::label('username', 'Username') }}
 	{{ Form::text('username') }}</p>
 	
 	<p>{{ Form::label('password', 'Password') }}
 	{{ Form::text('password') }}</p>
 
 	<p>{{ Form::label('password_confirmation', 'Password confirm') }}
 	{{ Form::text('password_confirmation') }}</p>
 
 	<p>{{ Form::submit('Submit') }}</p>
 
	{{ Form::close() }}
@stop