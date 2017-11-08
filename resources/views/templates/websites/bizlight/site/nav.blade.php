@php
	$tw = $nav->contents->where('type', 'twitterLink')->first();
	$fb = $nav->contents->where('type', 'facebookLink')->first();
	$gp = $nav->contents->where('type', 'googleLink')->first();
	$li = $nav->contents->where('type', 'linkedinLink')->first();	
@endphp

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand text-capitalize" href="/s/{{ $site->address }}">{{ $site->name }}</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="/s/{{ $site->address }}">Home</a></li>
				<li><a href="/s/{{ $site->address }}/about">About</a></li>
				<li><a href="/s/{{ $site->address }}/services">Services</a></li>
				<li><a href="/s/{{ $site->address }}/contact">Contact</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="{{ $tw->content }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
				<li><a href="{{ $fb->content }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<li><a href="{{ $gp->content }}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="{{ $li->content }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
