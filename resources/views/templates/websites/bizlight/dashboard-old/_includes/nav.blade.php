<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sideNavDropdown" aria-controls="sideNavDropdown"
			 aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="/">
		    <img src="/img/logo.png" width="50" height="50" class="d-inline-block align-center" alt="logo">
		    Create Website
	  	</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
			 aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto"></ul>
			<ul class="navbar-nav my-2">
				<li class="nav-item">
					<a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" 
						aria-haspopup="true" aria-expanded="false">
						{{ $site->user->name }}
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="#" 
	    					onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
	    				<form id="logout-form" action="/logout" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>