@extends("layout")
@section("content")

	{{ Form::open(array('route' => array('mod/register'), 'class' => 'form-signin' ,'method' => 'post')); }}
	<h2 class="form-signin-heading">Registrierung - Moderator</h2>

	{{ Form::label ('name', 'Username', array('class' => 'sr-only')); }}
	{{ Form::text ('name', null, array('id' => 'name', 'class' => 'form-control signin-input', 'placeholder' =>'Username'));}}

	{{ Form::label ('pwd', 'Passwort', array('class' => 'sr-only')); }}
	{{ Form::password ('pwd', array('id' => 'pwd', 'class' => 'form-control signin-input', 'placeholder' =>'Passwort'));}}

	{{ Form::submit('Registrieren', array('class' => 'btn btn-lg btn-danger btn-block')); }}
	{{ Form::close () }}
@stop

@section("js")
<script>
	$("#li_register").toggleClass( "active", true);
</script>
@stop