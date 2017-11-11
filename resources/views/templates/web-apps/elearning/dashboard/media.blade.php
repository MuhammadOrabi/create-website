@extends('layouts.vuetify')

@section('title')
	Dashboard - Create Website
@stop

@section('content')
	<v-layout row wrap justify-start>
		<v-flex xs12>
			<h1 class="headline">Media</h1>
    		<v-divider></v-divider>
    		<media token="{{ auth()->user()->getToken('elearning-homePage') }}" address="{{ $site->address }}"
    				type="media"></media>
		</v-flex>		
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.dashboard._includes.layout-script')
@stop