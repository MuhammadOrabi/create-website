@extends($site->theme->location . '.dashboard.layout')
@section('title')
    Media
@stop
@section('content')
    <media token="{{ auth()->user()->getToken('Media') }}" address="{{ $site->address }}"></media>    
@stop