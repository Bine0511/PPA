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
				<a href="{{ URL::route('index') }}" class="pull-left"><img class="navlogo" src="images/PPA_Logo-100-63.png"></a>
	          	<a class="navbar-brand" href="{{ URL::route('index') }}">Planning Poker App</a>
	      </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="collapse navbar-collapse" id="navbarCollapse">
	        <ul class="nav navbar-nav">
				@if (Auth::Mod()->check())
	            	<li id="li_logout"><a href="{{ URL::route('mod/logout') }}">Logout</a></li>
				@else
	            	<li id="li_login"><a href="{{ URL::route('mod/login') }}">Login</a></li>
	            	<li id="li_register"><a href="{{ URL::route('mod/register') }}">Registrierung</a></li>
	            	<li id="li_aboutus"><a href="{{ URL::route('info') }}" >&Uuml;ber uns</a></li>
	            @endif
	        </ul>
	      </div>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
@show