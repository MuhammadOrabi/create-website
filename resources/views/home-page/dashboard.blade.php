@extends('layouts.materialize')

@section('title')
	Dashboard - Create Website
@stop

@section('content')
	@include('home-page._includes.toolbar')
	<ul id="nav-sites" class="side-nav z-depth-5 fixed">
		@foreach($sites as $site)
			@php
				$id = $site->pages()->where('homePage', true)->get()->first()->id;
			@endphp
			<li><a class="subheader">{{ $site->name }}</a></li>
			<li><a href="/cms/pages/{{ $id }}/edit"  target="_blank"><i class="material-icons">edit</i>CMS</a></li> 
			<li><a href="/s/{{ $site->address }}" target="_blank"><i class="material-icons">launch</i>Open Site</a></li>
		    <li><div class="divider"></div></li>
		@endforeach
		<li><a href="/sites/create"><i class="material-icons">plus_one</i>Create New Site</a></li> 
    </ul>
@stop