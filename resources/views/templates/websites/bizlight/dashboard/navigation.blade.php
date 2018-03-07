@extends($site->theme->location . '.dashboard.layout')
@section('title')
    Navigation
@stop
@php
    $nav = $site->constants->where('type', 'top-nav')->first();
@endphp
@section('content')
    <navigation id="{{ $nav->id }}" token="{{ auth()->user()->getToken('navigation') }}" address="{{ $site->address }}"></navigation>
@stop