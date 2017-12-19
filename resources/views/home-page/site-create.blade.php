@extends('layouts.bulma')
@section('title')
	Create Website
@stop
@section('nav')
	@include('home-page._includes.nav.bulma-nav')
@stop
@section('content')
	<section class="container">
		<site-creator token="{{ auth()->user()->getToken('Site-Creator') }}"></site-creator>
	</section>	
@stop
