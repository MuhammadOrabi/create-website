@extends($site->theme->location . '.layouts.dashboard')

@section('title')
    {{ $page->title }}
@stop

@section('content')
    <h1 class="title">{{ $page->title }}</h1>
    @if($page->homePage)
    	<home-page address="{{ $site->address }}" token="{{ auth()->user()->getToken('users-manage') }}" id="{{ $page->id }}"></home-page>
    @elseif($page->slug === 'register')
        <users address="{{ $site->address }}" token="{{ auth()->user()->getToken('users-manage') }}"></users>
    @elseif($page->slug === 'courses')
        <courses id="{{ $page->id }}" address="{{ $site->address }}" token="{{ auth()->user()->getToken('courses-manage') }}"></courses>
    @elseif($page->slug === 'articles')
    	<articles id="{{ $page->id }}" address="{{ $site->address }}" token="{{ auth()->user()->getToken('articles-manage') }}"></articles>
    @endif
@stop