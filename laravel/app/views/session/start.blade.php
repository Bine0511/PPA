@extends("layout")
@section("content")
	<h1 style="text-align:center">Planning Poker Session "{{ Auth::PPSession()->get()->session_name }}" - User-Stories</h1>
	<ul class="list-group" style="width: 80%; margin: auto">
	@foreach ($userstories as $story)
		@if ($story->userstory_ID == $basestory->session_basestory_id)
		<li class="list-group-item list-group-item-danger">
		@else
		<li class="list-group-item">
		@endif

			{{ "<span class='us_tex'><big><b>".$story->userstory_name."</b>: ".$story->userstory_description."</big></span>"}}
			<div style="float:right">
				{{ Form::open(array('route' => array('session/start'), 'style' => 'display:inline', 'method' => 'post')) }}
 					{{ Form::hidden('basestory', $story->userstory_ID ) }}
 					{{ Form::submit('als Basis setzen', array('class' => 'btn btn-default')) }}
				{{ Form::close() }}
				{{ Form::open(array('route' => array('session/start'), 'style' => 'display:inline', 'method' => 'post')) }} 
 					{{ Form::hidden('deleteStory', $story->userstory_ID ) }}
 					{{ Form::submit('Userstory löschen', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
			</div>
			<div style="clear: both"></div>


		</li>
	@endforeach
	</ul>
	{{ Form::open(array('route' => array('session/start'), 'class' => 'form-signin', 'method' => 'post')) }}
 	
 	<p>{{ Form::label('userstory', 'User-Story', array('class' => 'sr-only')) }}
 	{{ Form::text('userstory', null, array('id' => 'session', 'class' => 'form-control signin-input', 'placeholder' =>'Userstory')) }}</p>
 
 	<p>{{ Form::label('description', 'Beschreibung (Optional)', array('class' => 'sr-only')) }}
 	{{ Form::text('description', null, array('id' => 'session', 'class' => 'form-control signin-input', 'placeholder' =>'Beschreibung')) }}</p>
 
 	<p>{{ Form::submit('Hinzufügen', array('class' => 'btn btn-lg btn-danger btn-block')) }}</p>
 
	{{ Form::close() }}


	<p class="form-signin">
		<a href="{{ URL::route('mod/moderator') }}"  class="btn btn-lg btn-success btn-block">Session starten</a>
	</p>

@stop

@section("js")
<script>
	$("#li_session").toggleClass( "active", true);
</script>
@stop