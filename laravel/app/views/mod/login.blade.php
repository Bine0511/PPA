@extends("layout")
@section("content")

	{{ Form::open(array(null, 'class' => 'form-signin' ,'method' => 'post')); }}
	<h2 class="form-signin-heading">Login - Moderator</h2>
	{{ $errors->first("password") }}
		<!--@if (isset($error))
			{{ $error }}<br />
		@endif-->

	{{ Form::label ('name', 'Username', array('class' => 'sr-only')); }}
	{{ Form::text ('name', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Username'));}}

	{{ Form::label ('pwd', 'Passwort', array('class' => 'sr-only')); }}
	{{ Form::password ('pwd', array('id' => 'pwd', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort'));}}

	{{ Form::submit('Login', array('class' => 'btn btn-lg btn-danger btn-block')); }}
	{{ Form::close () }}
@stop

@section("js")
<script>
	$("#li_login").toggleClass( "active", true);
</script>
@stop