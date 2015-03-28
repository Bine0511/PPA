@extends("layout")
@section("content")
<div>
	<h1 style="text-align:center">Willkommen zu Planning Poker App!</h1>

	@if (Auth::Mod()->check())
	<p class="form-signin">
		<a href="{{ URL::route('session/create') }}" class="btn btn-lg btn-danger btn-block">Session erstellen</a>
	</p>
	@else
	<p class="form-signin">
		<a href="{{ URL::route('user/join') }}" class="btn btn-lg btn-danger btn-block">Session beitreten</a>
	</p>
	@endif

</div>
@stop
