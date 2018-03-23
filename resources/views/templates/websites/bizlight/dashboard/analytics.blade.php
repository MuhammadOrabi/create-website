@extends($site->theme->location . '.dashboard.layout')
@section('title')
    Analytics
@stop
@section('content')
    <analytics-page address="{{ $site->address }}"></analytics-page>    
@stop