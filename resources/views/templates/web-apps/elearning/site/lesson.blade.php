@extends('layouts.vuetify')

@section('title')
	Lesson - {{ $site->name }}
@stop

@section('content')
	<site-lesson address="{{ $site->address }}" id="{{ $page->id }}"></site-lesson>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop