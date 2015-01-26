@section("header")
	<div class="header">
			<div class="menu">
			@if (Auth::check())
				<a href="{{ URL::route('mod/logout') }}">
					logout
				</a>
			@else
				<a href="{{ URL::route('mod/login') }}">
					Login
				</a>
				<a href="{{ URL::route('mod/register') }}">
					Register
				</a>
			@endif
		</div>
	</div>
@show