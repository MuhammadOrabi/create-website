<div class="side-menu" id="left-side-menu">
	<aside class="menu m-t-30 m-l-10">
		<p class="menu-label">General</p>
		<ul class="menu-list">
			<li>
				<a href="/s/{{ $site->address }}" target="_blank">
					<span class="icon"><i class="fa fa-fw m-r-10 fa-external-link"></i></span>Open Site
				</a>
			</li>
			<li>
				<a href="/dashboard/analytics/{{ $site->address }}" class="{{ Nav::hasSegment('analytics',2) }}">
					<span class="icon"><i class="fa fa-fw m-r-10 fa-bar-chart"></i></span>Analytics
				</a>
			</li>			
		</ul>
		<p class="menu-label">Content</p>
		<ul class="menu-list">
			<li>
				<a class="has-submenu {{ Nav::hasSegment('pages', 2) }}" href="#">
					<span class="icon"><i class="fa fa-fw m-r-10 fa-list"></i></span>Pages
				</a>
				<ul class="submenu">
					@foreach($pages as $page)
						<li>
							<a href="/dashboard/pages/{{ $page->id }}/edit/{{ $site->address }}" class="{{ Nav::hasSegment($page->id,3) }}">
								{{ $page->title }}
							</a>
						</li>
					@endforeach
				</ul>
			</li>
			<li>
				<a href="/dashboard/media/{{ $site->address }}" class="{{ Nav::hasSegment('media',2) }}">
					<span class="icon"><i class="fa fa-fw m-r-10 fa-picture-o"></i></span>Media
				</a>
			</li>
		</ul>
		<p class="menu-label">Administration</p>
		<ul class="menu-list">
			<li>
				<a href="/dashboard/settings/{{ $site->address }}" class="{{ Nav::hasSegment('settings',2) }}">
					<span class="icon"><i class="fa fa-fw m-r-10 fa-gear"></i></span>Settings
				</a>
			</li>			
			<li><a href="/site/create"><span class="icon"><i class="fa fa-fw m-r-10 fa-plus"></i></span>Create New Site</a></li>			
		</ul>
	</aside>
</div>