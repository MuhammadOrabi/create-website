@extends('layouts.vuetify')

@section('title')
	Settings - Create Website
@stop

@section('content')
	<v-layout row wrap justify-start>
		<v-flex xs12>
			<h1 class="headline">Settings</h1>
    		<v-divider></v-divider>
		</v-flex>		
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.dashboard._includes.layout-script')
@stop