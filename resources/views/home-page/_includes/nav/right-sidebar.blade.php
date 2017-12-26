<div class="side-menu" id="right-side-menu">
	<aside class="menu m-t-30 m-l-10">
		<ul class="menu-list">
			@guest
				<li><a href="/login">Login</a></li>
				<li><a href="/register">Join Us</a></li>
			@else
				<li>
					<a href="/home" target="_blank">
						<span class="icon"><i class="fa fa-fw m-r-10 fa-dashboard"></i></span>Sites
					</a>
				</li>
				<li><a href="/site/create"><span class="icon"><i class="fa fa-fw m-r-10 fa-plus"></i></span>Create New Site</a></li>
				<p class="menu-label is-capitalized">{{ auth()->user()->name }}</p>
				<li>
					<a href="/logout" 
						onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						<span class="icon"><i class="fa fa-fw m-r-10 fa-sign-out"></i></span> Logout
					</a>
					@include('home-page._includes.forms.logout')
				</li>
			@endguest
		</ul>
	</aside>
</div>