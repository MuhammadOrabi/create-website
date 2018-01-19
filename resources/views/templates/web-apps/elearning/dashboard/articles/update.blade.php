@extends($site->theme->location . '.layouts.dashboard')

@section('title')
	{{ $page->title }}
@stop

@section('content')
	<div class="columns">
		<div class="column is-one-quarter">
			<a class="subtitle" href="/dashboard/pages/{{ $page->id }}/{{ $site->address }}">
				<span class="icon">
					<i class="fa fa-arrow-left"></i>
				</span>
				Back to Articles
			</a>
		</div>
		<div class="column">
			<h1 class="title">Update an Article</h1>            
		</div>
	</div>
	<articles-cu u address="{{ $site->address }}" token="{{ auth()->user()->getToken('articles-cu') }}" 
				page="{{ $page->id }}" id="{{ $section->id }}"></articles-cu>
@stop