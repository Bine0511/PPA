@extends("layout")
@section("content")
<div>
	<h1>Planning Poker Session "{{ Auth::PPSession()->get()->session_name }}"</h1>
	<h2>User-Stories</h2>
	<ul>
	@foreach ($userstories as $story)
		<li>{{ $story->userstory_name.": ".$story->userstory_description }}</li>
	@endforeach
	</ul>

	{{ Form::open(array('route' => array('session/start'), 'method' => 'post')) }}
 	
 	<p>{{ Form::label('pwd', 'User-Story') }}
 	{{ Form::password('pwd') }}</p>
 
 	<p>{{ Form::label('name', 'Beschreibung (Optional)') }}
 	{{ Form::password('name') }}</p>
 
 	<p>{{ Form::submit('Hinzufügen') }}</p>
 
	{{ Form::close() }}

	<a href="#">Über Planning Poker App</a>
	<a href="#">Wie funktioniert Planning Poker?</a>
</div>
@stop
