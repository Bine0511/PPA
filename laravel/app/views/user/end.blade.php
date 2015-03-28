@extends("layout")
@section("content")
<div>
	<h1 style="text-align:center">Vielen Dank für die Teilnahme!</h1>

	<div class="form-signin">
		{{ Form::open(array('route' => array('user/logout'), 'style' => 'display:inline', 'method' => 'post')) }}
 			{{ Form::submit('Zurück zur Startseite', array('class' => 'btn btn-danger btn-lg btn-block')) }}
		{{ Form::close() }}
	</div>

</div>
@stop
