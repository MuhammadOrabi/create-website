 <nav class="navbar has-shadow is-fixed-top" style="transform: translateY(0px);">
	<div class="container">
		<div class="navbar-brand">
			<a href="/" class="navbar-item is-paddingless">
				<img src="/img/logo.png" alt="Logo">
                <span class="p-l-10">Create Website</span>
			</a>
			@if(Request::segment(1) == 'dashboard')
				<a class="navbar-item is-hidden-desktop" id="left-slideout-button">
					<span class="icon"><i class="fa fa-arrow-circle-o-right"></i></span>
				</a>
			@endif
			<button class="button navbar-burger" id="right-slideout-button">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
		<div class="navbar-menu">
			<div class="navbar-start"></div>
			<div class="navbar-end nav-menu " style="overflow: visible">
				@guest
					<a href="/login" class="navbar-item is-tab {{ Nav::isRoute('login') }}">Login</a>
					<a href="/register" class="navbar-item is-tab {{ Nav::isRoute('register') }}">Join Us</a>
				@else
					<div class="navbar-item has-dropdown is-hoverable">
						<a href="#" class="navbar-link">Hey, {{ Auth::user()->name }}</a>
						<div class="navbar-dropdown is-right">
							<a href="/home" class="navbar-item">
								<span class="icon"><i class="fa fa-fw m-r-10 fa-dashboard"></i></span> Sites
							</a>
							<a href="/create/site" class="navbar-item">
								<span class="icon"><i class="fa fa-fw m-r-10 fa-plus"></i></span> Create New Site
							</a>
							<hr class="seperator">
							<a class="navbar-item" href="/logout" 
								onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<span class="icon"><i class="fa fa-fw m-r-10 fa-sign-out"></i></span> Logout
							</a>
                            @include('home-page._includes.forms.logout')
						</div>
					</div>
				@endguest
			</div>
		</div>
	</div>
</nav>