@extends("layout")
@section("content")
	{{ Form::open() }}
	{{ Form::button ("Show PDF") }}
	{{ Form::close () }}
@stop