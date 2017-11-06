<nav class="white" role="navigation">
	<div class="nav-wrapper container">
		<a id="logo-container" href="/" class="brand-logo">
			<img src="/img/logo.png" alt="logo" width="50px" height="50px" class="responsive-img">
			<span class="hide-on-med-and-down">Create Website</span>
		</a>
		<ul class="right hide-on-med-and-down">
			@if (Auth::guest())
	            <li><a href="/login">Login</a></li>
	            <li><a href="/register">Register</a></li>
	        @else
	            <li><a href="/home">Home</a></li>
    	      	<li>
        	      	<a class="dropdown-button" href="#!" data-hover="true" data-beloworigin="true" data-activates="userMinue">
        	      		{{ Auth()->user()->name }}<i class="material-icons right">arrow_drop_down</i>
        	      	</a>
    	      	</li>

	            <li>
	            	<a class="dropdown-button" href="#" data-hover="true" data-beloworigin="true" data-activates="userMinue">

	            	</a>
            	</li>
	            <ul id='userMinue' class='dropdown-content'>
    				<li><a href="{{ route('logout') }}" 
    					onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
    				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
    			</ul>
	        @endif
		</ul>

		<ul id="nav-mobile" class="side-nav">
			@if (Auth::guest())
	            <li><a href="/login">Login</a></li>
	            <li><a href="/register">Register</a></li>
	        @else
	            <li><a href="/home">Home</a></li>
	            <li>
	            	<a class="dropdown-button" href="#" data-beloworigin="true" data-hover="true" data-activates="dropdown1">
	            		{{ Auth()->user()->name }} <i class="material-icons right">arrow_drop_down</i>
	            	</a>
            	</li>
	            <ul id='dropdown1' class='dropdown-content'>
    				<li><a href="/logout">Logout</a></li>
    			</ul>
	        @endif
		</ul>
		@if(Request::segment(1) == 'home')
			<a href="#" data-activates="nav-sites" class="button-collapse right">Sites <i class="material-icons right">arrow_drop_down</i></a>
		@endif
		<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
	</div>
</nav>
