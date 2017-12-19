@extends('layouts.bulma')

@section('title')
    Dashboard - Create Website
@stop
@section('nav')
    @include('home-page._includes.nav.bulma-nav')
    @include($site->theme->location.'.dashboard._includes.sidebar')
@stop
@section('content')

@stop