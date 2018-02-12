@extends($site->theme->location . '.site.layout')

@section('title')
	{{ $site->name }}
@stop

@php
    $leftShowCase = $page->sections->where('title', 'Left Show Case')->first();
@endphp

@section('content')
	<div class="row">
    	@include($site->theme->location . '.site.leftShowCase')

	    <!--Side-right section-->
        @if($leftShowCase->active && $leftShowCase->contents->isNotEmpty())
    	    <div class="col s12  l9">
        @else
            <div class="col s12">
        @endif
			@include($site->theme->location . '.site.nav')
			
			@include($site->theme->location . '.site.home')
		  	
			@include($site->theme->location . '.site.about')
		  	
			@include($site->theme->location . '.site.skill')
  			
			@include($site->theme->location . '.site.education')

			@include($site->theme->location . '.site.experience')
  			
			@include($site->theme->location . '.site.contact')		

    	</div><!--end row-->  
    </div>
@stop
