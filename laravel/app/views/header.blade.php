@section("header")
	<div class="header">
			<div class="menu">
			@if (Auth::check())
				<a href="{{ URL::route('user/logout') }}">
					logout
				</a>
			@else
				<a href="{{ URL::route('user/login') }}">
					Login
				</a>
				<a href="{{ URL::route('user/register') }}">
					Register
				</a>
			@endif
		</div>
	</div>
@show