@extends($site->theme->location . '.dashboard.layout')

@section('title')
    Media
@stop

@section('content')
	<h1 class="title">Media</h1>
    <hr>
    <media address="{{ $site->address }}" token="{{ auth()->user()->getToken('media') }}"></media>
@stop