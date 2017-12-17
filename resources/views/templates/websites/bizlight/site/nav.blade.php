<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand text-capitalize" href="/s/{{ $site->address }}" >
				@if($nav['logo'])
					<img style="display:inline-block !important;vertical-align:top !important; position: absolute; top: 10px" 
						alt="Brand" src="{{$nav['logo']->content}}" height="50px" width="50px">
				@endif
				<span style="padding-left:60px">{{ $site->name }}</span>
			</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="/s/{{ $site->address }}">Home</a></li>
				<li><a href="/s/{{ $site->address }}/about">About</a></li>
				<li><a href="/s/{{ $site->address }}/services">Services</a></li>
				<li><a href="/s/{{ $site->address }}/contact">Contact</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				@foreach($nav['links'] as $link)
					<li><a href="{{ $link->content }}" target="_blank"><i class="fa fa-{{$link->title}}"></i></a></li>
				@endforeach
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
