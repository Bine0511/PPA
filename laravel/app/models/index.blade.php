@extends("layout")
@section("content")
<div>
	<h1>Willkommen zu Planning Poker App!</h1>

	@if (Auth::Mod()->check())
		<a href="{{ URL::route('session/create') }}">Session erstellen</a>
	@else
		<a href="{{ URL::route('user/join') }}">Session beitreten</a>
	@endif

</div>
@stop
