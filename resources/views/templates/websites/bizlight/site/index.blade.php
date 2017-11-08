@extends($site->theme->location . '.site.layout')

@php
	$showCase = $page->sections->where('title', 'showCase')->first();
	$sectionB = $page->sections->where('title', 'section_b')->first();
	$sectionBimg = $sectionB->contents->where('type', 'img')->first();
	$sectionA = $page->sections->where('title', 'section_a')->first();
	$filteredA = $sectionA->contents->groupBy('order')->filter(function ($value, $key) {
	    return $value[2]->content != null;
	});
@endphp

@section('content')
	@isset($showCase)
		<div class="showcase">
			<div class="container">
				<h1>{{ $showCase->contents()->where('type', 'heading')->first()->content }}</h1>
				<p class="lead">
					{{ $showCase->contents()->where('type', 'paragraph')->first()->content }}
				</p>
				<a href="/s/{{$site->address}}/about" class="btn btn-primary">Read More</a>
			</div>
		</div>
	@endisset
	@isset($sectionB)
	    <div class="section-b">
	    	<div class="container">
	    		<div class="row">
	    			<div class="col-md-6">
	    				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	    					<br><br><br><br>
							@foreach($sectionB->contents->groupBy('order') as $content)
								@if($content[0]->type != 'img' && $content[0]->content != null)
									<div class="panel panel-default">
									    <div class="panel-heading" role="tab" id="heading-{{$content[0]->id}}">
									      	<h4 class="panel-title">
										        <a role="button" data-toggle="collapse" data-parent="#accordion" 
										        	href="#collapse-{{$content[0]->id}}" style="text-decoration: none;" aria-expanded="true" 
										        	aria-controls="collapse-{{$content[0]->id}}">
										          {{ $content[0]->content }}
										        </a>
									      	</h4>
									    </div>
								    	<div id="collapse-{{$content[0]->id}}" class="panel-collapse collapse"
									    	role="tabpanel" aria-labelledby="heading-{{$content[0]->id}}">
									      	<div class="panel-body">
										          {{ $content[1]->content }}
									      	</div>
									    </div>
								  	</div>
							  	@endif
						  	@endforeach
						</div>
	    			</div>
	    			<div class="col-md-6">
	    				<img src="{{ $sectionBimg->content }}" alt="img" width="250" height="350">
	    			</div>
	    		</div>
	    	</div>
	    </div>
  	@endisset
	@isset($filteredA)
	    <div class="section-a">
			<div class="container">
				<div class="row">
						@foreach($filteredA as $content)
							<div class="col-md-{{ 12/$loop->count }}">
								<div class="row m-5">
									<img src="{{ $content[2]->content }}" class="img-circle" alt="img" width="150" height="150">
								</div>
								<h3>{{ $content[0]->content }}</h3>
								<p>{{ $content[1]->content }}</p>
							</div>
						@endforeach
				</div>
			</div>
		</div>
	@endisset
	@php 
		$sectionC = $page->sections->where('title', 'section_c')->first();
		$par = $sectionC->contents->where('type', 'paragraph')->first();
		$img = $sectionC->contents->where('type', 'img')->first();
	@endphp
	@isset($sectionC)
		<div class="section-c">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<img src="{{ $img->content }}" alt="img" height="350" width="250">
					</div>
					<div class="col-md-6">
						<blockquote class="blockquote">
								<p class="mb-0">{{ $par->content }}</p>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	@endisset

@stop
