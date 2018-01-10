@extends($site->theme->location . '.layouts.dashboard')

@section('title')
    Media
@stop

@section('content')
    <media address="{{ $site->address }}" token="{{ auth()->user()->getToken('media') }}"></media>
@stop