@extends("layout")
@section("content")

	{{ Form::open(array(null, 'class' => 'form-signin' ,'method' => 'post')); }}
	<h2 class="form-signin-heading">Login für Administratoren</h2>
	@if (Session::has('login_errors'))
        <span class="error">Username or password incorrect.</span>
    @endif
		<!--@if (isset($error))
			{{ $error }}<br />
		@endif-->

	{{ Form::label ('name', 'Username', array('class' => 'sr-only')); }}
	{{ Form::text ('name', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Username'));}}

	{{ Form::label ('password', 'Passwort', array('class' => 'sr-only')); }}
	{{ Form::password ('password', array('id' => 'password', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort'));}}

	{{ Form::submit('Login', array('class' => 'btn btn-lg btn-primary btn-block')); }}
	{{ Form::close () }}

<script>
$("#li_login").toggleClass( "active", true);
</script>
@stop