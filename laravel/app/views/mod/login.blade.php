@extends("layout")
@section("content")

	{{ Form::open(array(null, 'class' => 'form-signin' ,'method' => 'post')); }}
	<h2 class="form-signin-heading">Login für Administratoren</h2>
	{{ $errors->first("password") }}
		<!--@if (isset($error))
			{{ $error }}<br />
		@endif-->

	{{ Form::label ('username', 'Username', array('class' => 'sr-only')); }}
	{{ Form::text ('username', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Username'));}}

	{{ Form::label ('password', 'Passwort', array('class' => 'sr-only')); }}
	{{ Form::password ('password', array('id' => 'password', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort'));}}

	{{ Form::submit('login', array('class' => 'btn btn-lg btn-danger btn-block')); }}
	{{ Form::close () }}
@stop

@section("js")
<script>
	$("#li_login").toggleClass( "active", true);
</script>
@stop