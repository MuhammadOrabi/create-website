@extends($site->theme->location . '.dashboard.layout')
@section('title')
    Media
@stop
@section('content')
    <section>
        <media address="{{ $site->address }}" token="{{ auth()->user()->getToken('media') }}"></media>
    </section>
@stop