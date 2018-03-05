@extends($site->theme->location . '.dashboard.layout')
@section('title')
    {{ $page->title }}
@stop
@section('content')
    <section>
        @if($page->homePage)
            <home-page token="{{ auth()->user()->getToken('home-page') }}" id="{{ $page->id }}"></home-page>
        @elseif($page->slug == 'about')
            <about token="{{ auth()->user()->getToken('about') }}" id="{{ $page->id }}"></about>            
        @elseif($page->slug == 'services')
        @elseif($page->slug == 'contact')
        @endif
    </section>
@stop