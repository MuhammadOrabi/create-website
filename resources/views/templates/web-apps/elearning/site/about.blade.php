@extends('layouts.vuetify')

@section('title')
	About - {{ $site->name }}
@stop

@section('content')
	<v-layout row wrap justify-start>
		<site-about id="{{ $page->id }}"></site-about>		
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop