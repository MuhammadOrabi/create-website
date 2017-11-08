@extends($site->theme->location . '.site.layout')

@section('title')
	Services |
@stop

@php
	$section = $page->sections->where('title', 'servicesSection')->first();		
@endphp
@section('content')
	<div class="title-bar">
		<div class="container">
			<h1>Services</h1>
		</div>
	</div>
	<div class="main" >
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">What we Do?</h4>
						</div>
						<div class="panel-body">
							@foreach($section->contents->groupBy('order') as $content)
								@isset($content[0]->content)
									<div class="well">
										<h4>{{ $content[0]->content }}</h4>
										<p>{{ $content[1]->content }}</p>
									</div>
								@endisset
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
