@extends('layouts.vuetify')

@section('title')
	{{ $section->title }} - Create Website
@stop

@section('content')
	<v-layout row wrap justify-start>
		<v-flex xs12>
    		<lessons token="{{ auth()->user()->getToken('Lessons') }}" address="{{ $site->address }}"
    			id="{{ $section->id }}"></lessons>
    	</v-flex>
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.dashboard._includes.layout-script')
@stop