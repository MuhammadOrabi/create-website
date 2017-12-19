@extends('layouts.vuetify')

@section('title')
	Dashboard - {{ $site->name }}
@stop

@section('content')
	<v-layout row wrap justify-start>
		<site-profile id="{{ $page->id }}" address="{{ $site->address }}"></site-profile>
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop