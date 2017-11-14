@extends('layouts.vuetify')

@section('title')
	Sign Up - {{ $site->address }}
@stop

@section('content')
	<site-signup address="{{ $site->address }}"></site-signup>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.site._includes.layout-script')
@stop