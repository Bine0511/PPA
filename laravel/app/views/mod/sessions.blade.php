@extends("layout")
@section("content")
<div>
	<h1 style="text-align:center">Meine Sessions</h1>
	<ul class="list-group" style="width: 80%; margin: auto">
	@foreach ($sessions as $session)
		<li class="list-group-item">
			<p>{{ $session->session_name }}</p>
			<div style="float:right">
				{{ Form::open(array('route' => array('session/login'), 'style' => 'display:inline', 'method' => 'post')) }} 
 					{{ Form::hidden('session_ID', $session->session_ID ) }}
 					{{ Form::submit('Session-Login', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
			</div>
			<div style="clear: both"></div>
		</li>
	@endforeach
	</ul>
	<p class="form-signin">
		<a href="{{ URL::route('session/create') }}"  class="btn btn-lg btn-danger btn-block">Session erstellen</a>
	</p>
</div>
@stop

@section("js")
<script>
	$("#li_mysessions").toggleClass( "active", true);
</script>
@stop