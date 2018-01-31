@extends($site->theme->location . '.layouts.dashboard')

@section('title')
    Navigation
@stop

@section('content')
    <h1 class="title">Navigation</h1>
    <navigation token="{{ auth()->user()->getToken('navigation') }}" address="{{ $site->address }}"></navigation>
@stop