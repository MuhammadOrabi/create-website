<div class="collapse navbar-collapse show" id="sideNavDropdown">
	<nav class="col-sm-3 col-md-2 d-sm-block bg-light sidebar">
		<ul class="nav flex-column pt-4">
			<li class="nav-item">
				<a class="nav-link" href="/s/{{ $site->address }}" target="_blank">
					<i class="fa fa-external-link" aria-hidden="true"></i> Open Site
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ navHasSegment('analytics', 2) }}" href="/dashboard/analytics/{{ $site->address }}">
					<i class="fa fa-bar-chart" aria-hidden="true"></i> Analytics
				</a>
			</li>
		</ul>
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link {{ navHasSegment('navigation', 2) }}" href="/dashboard/navigation/{{ $site->address }}">
					<i class="fa fa-navicon" aria-hidden="true"></i> Navigation
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ navHasSegment($site->pages->pluck('id')->toArray(), 3) }}" data-toggle="collapse" href="#collapseOne" 
					aria-expanded="true" aria-controls="collapseOne">
		          	<i class="fa fa-chevron-down" aria-hidden="true"></i> Pages
		        </a>
			</li>
		    <div id="collapseOne" class="collapse {{ navHasSegment($site->pages->pluck('id')->toArray(), 3, 'show') }}" 
		    		role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
				<ul class="nav flex-column p-3">
					@foreach($site->pages as $navPage)
						<li class="nav-item">
							<a class="nav-link {{ navHasSegment($navPage->id, 3) }}" href="/dashboard/pages/{{ $navPage->id }}/edit">
								<i class="fa fa-chevron-right" aria-hidden="true"></i>  {{$navPage->title}}
							</a>
						</li>
					@endforeach
				</ul>
			</div>
			<li class="nav-item">
				<a class="nav-link {{ navHasSegment('media', 2) }}" href="/dashboard/media/{{ $site->address }}">
					<i class="fa fa-picture-o" aria-hidden="true"></i> Media
				</a>
			</li>
		</ul>
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link {{ navHasSegment('settings', 2) }}" href="/dashboard/settings/{{ $site->address }}">
					<i class="fa fa-gear" aria-hidden="true"></i> Settings
				</a>
			</li>
			<li class="nav-item">
	    		<a class="nav-link" href="/site/create"><i class="fa fa-plus" aria-hidden="true"></i> Create new site</a>
			</li>
		</ul>
	</nav>
</div>