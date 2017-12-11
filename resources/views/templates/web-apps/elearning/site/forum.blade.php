@extends('layouts.vuetify')

@section('title')
	Forum - {{ $site->name }}
@stop

@section('content')
	<v-layout row wrap justify-start>
		<site-forum id="{{ $id }}" address="{{ $site->address }}"></site-forum>
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop