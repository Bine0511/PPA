@extends("layout")
@section("content")

	{{ Form::open(array('route' => array('mod/register'), 'class' => 'form-signin' ,'method' => 'post')); }}
	<h2 class="form-signin-heading">Registrierung für Administratoren</h2>

	{{ Form::label ('name', 'Username', array('class' => 'sr-only')); }}
	{{ Form::text ('name', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Username'));}}

	{{ Form::label ('pwd', 'Passwort', array('class' => 'sr-only')); }}
	{{ Form::password ('pwd', array('id' => 'pwd', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort'));}}

	{{ Form::label ('pwd_confirmation', 'Passwort wiederholen', array('class' => 'sr-only')); }}
	{{ Form::password ('pwd_confirmation', array('id' => 'pwd_confirmation', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort wiederholen'));}}

	{{ Form::submit('Registrieren', array('class' => 'btn btn-lg btn-success btn-block')); }}
	{{ Form::close () }}

	<script>
$("#li_register").toggleClass( "active", true);
</script>
@stop