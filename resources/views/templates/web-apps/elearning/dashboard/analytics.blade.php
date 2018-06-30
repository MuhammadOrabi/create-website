@extends($site->theme->location . '.layouts.dashboard')

@section('title')
    Analytics
@stop

@section('content')
    <h1 class="title">Analytics</h1>
    <analytics address="{{ $site->address }}"></analytics>
@stop