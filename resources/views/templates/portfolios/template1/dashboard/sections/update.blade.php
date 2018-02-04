@extends($site->theme->location . '.dashboard.layout')
@section('title')
    {{ $section->title }}
@stop
@section('content')
    <h1 class="title">{{ $section->title }}</h1>
    
@stop