@section("header")
	<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
	    <!-- Brand and toggle get grouped for better mobile display -->
	  	<div class="container">
	     	<div class="navbar-header">
	          	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
	              	<span class="sr-only">Toggle navigation</span>
	              	<span class="icon-bar"></span>
	              	<span class="icon-bar"></span>
	              	<span class="icon-bar"></span>
	          	</button>
				<a href="{{ URL::route('index') }}" class="pull-left">{{HTML::image("/images/PPA_Logo-100-63.png", "Logo", array('class' => 'navlogo'))}}</a>
	          	<a class="navbar-brand" href="{{ URL::route('index') }}">Planning Poker App</a>
	      </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="collapse navbar-collapse" id="navbarCollapse">
	        <ul class="nav navbar-nav">
	            <li id="li_aboutus"><a href="{{ URL::route('info') }}" >&Uuml;ber uns</a></li>
				
				@if (Auth::Mod()->check())
	            	@if(Auth::PPSession()->check())
					<li id="li_session"><a href="{{ URL::route('session/logout') }}">Meine Sessions</a></li>
					@else
					<li id="li_mysessions"><a href="{{ URL::route('mod/sessions') }}">Meine Sessions</a></li>
					@endif
					<li id="li_logout"><a href="{{ URL::route('mod/logout') }}">Logout ({{ Auth::Mod()->get()->moderator_name }})</a></li>
				@else
	            	<li id="li_login"><a href="{{ URL::route('mod/login') }}">Login</a></li>
	            	<li id="li_register"><a href="{{ URL::route('mod/register') }}">Registrierung</a></li>
	            @endif
	        </ul>
	      </div>
	    </div><!-- /.navbar-collapse -->
	</nav>
@show