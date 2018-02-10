@extends($site->theme->location . '.dashboard.layout')
@section('title')
    Settings
@stop
@section('content')
    <h1 class="title">Settings</h1>
    <settings address="{{ $site->address }}" id="{{ $site->id }}" token="{{ auth()->user()->getToken('settings') }}"></settings>
@stop