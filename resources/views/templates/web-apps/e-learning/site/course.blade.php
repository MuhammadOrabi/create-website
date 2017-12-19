@extends('layouts.vuetify')

@section('title')
	Course - {{ $site->name }}
@stop


@section('content')
	<site-course address="{{ $site->address }}" id="{{ $id }}"></site-course>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop