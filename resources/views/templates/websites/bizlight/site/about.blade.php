@extends($site->theme->location . '.site.layout')

@section('title')
	 About |
@stop

@php
    $contents = optional($section)->contents;
    $paragraph = optional($contents)->first();
@endphp

@section('content')
	
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
                            @if($paragraph)
                                <p>{!! $paragraph->content !!}</p>
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop
