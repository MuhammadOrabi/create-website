@extends($site->theme->location . '.site.layout')

@section('title')
	Services |
@stop


@php
    $contents = optional($section)->contents;
    $ordered = optional($contents)->groupBy('order');
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
                            @if($ordered)
                                @foreach($ordered as $content)
                                    @isset($content[0]->content)
                                        <div class="well">
                                            <h4>{!! $content[0]->content !!}</h4>
                                            <p>{!! $content[1]->content !!}</p>
                                        </div>
                                    @endisset
                                @endforeach
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
