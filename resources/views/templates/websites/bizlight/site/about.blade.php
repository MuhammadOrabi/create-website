@extends($site->theme->location . '.site.layout')

@section('title')
	 About |
@stop

@section('content')
	<?php 
		$section = $page->sections->where('title', 'aboutSection')->first();
	?>
	
	<div class="title-bar">
		<div class="container">
			<h1>About</h1>
		</div>
	</div>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Who we Are?</h4>
						</div>
						<div class="panel-body">
							<p>{{ $section->contents->first()->content }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop
