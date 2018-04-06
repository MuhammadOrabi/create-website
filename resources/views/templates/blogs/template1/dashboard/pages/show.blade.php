@extends($site->theme->location . '.dashboard.layout')

@section('title')
    {{ $page->title }}
@stop

@section('content')
    <h1 class="title">{{ $page->title }}</h1>
    @if($page->homePage)
    	<home-page address="{{ $site->address }}" token="{{ auth()->user()->getToken('home-page') }}" id="{{ $page->id }}"></home-page>
    @elseif($page->slug === 'pages')
        <pages address="{{ $site->address }}" token="{{ auth()->user()->getToken('pages') }}"  id="{{ $page->id }}"></pages>
    @endif
@stop