@extends($site->theme->location . '.dashboard.layout')

@section('title')
    Footer
@stop

@php
    $id = $site->constants()->where('type', 'footer')->first()->id;
@endphp

@section('content')
    <h1 class="title">Footer</h1>
    <footer-settings token="{{ auth()->user()->getToken('footer-settings') }}" id="{{ $id }}" address="{{ $site->address }}" ></footer-settings>
@stop