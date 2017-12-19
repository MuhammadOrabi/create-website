@extends('layouts.vuetify')

@section('title')
	Coureses - {{ $site->name }}
@stop

@section('content')
	<site-courses address="{{ $site->address }}" id="{{ $page->id }}"></site-courses>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop