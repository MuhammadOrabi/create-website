@extends($site->theme->location . '.layouts.dashboard')

@section('title')
    {{ $page->title }}
@stop

@section('content')
    <h1 class="title">{{ $page->title }}</h1>
    <hr>
@stop