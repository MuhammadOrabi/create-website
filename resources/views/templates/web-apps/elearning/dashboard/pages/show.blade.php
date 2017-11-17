@extends('layouts.vuetify')

@section('title')
	Courses - Create Website
@stop

@section('content')
	<v-layout row wrap justify-start>
	    @if($page->title == 'Home Page')
	    	<v-flex xs12>
	    		<h1 class="headline">{{$page->title}}</h1>
	    		<v-divider></v-divider>
	    		<home-page token="{{ auth()->user()->getToken('elearning-homePage') }}" address="{{ $site->address }}"
	    			id="{{ $page->id }}" ></home-page>
	    	</v-flex>
		@elseif($page->title == 'About')
			<v-flex xs12>
	    		<h1 class="headline">{{$page->title}}</h1>
	    		<v-divider></v-divider>
	    		<about token="{{ auth()->user()->getToken('elearning-about') }}" address="{{ $site->address }}"
	    			id="{{ $page->id }}" ></about>
	    	</v-flex>
		@elseif($page->title == 'News')
			<v-flex xs12>
	    		<h1 class="headline">{{$page->title}}</h1>
	    		<v-divider></v-divider>
	    		<news token="{{ auth()->user()->getToken('elearning-news') }}" address="{{ $site->address }}"
	    			id="{{ $page->id }}" ></news>
	    	</v-flex>
		@elseif($page->title == 'Contact')
			<v-flex xs12>
	    		<h1 class="headline">{{$page->title}}</h1>
	    		<v-divider></v-divider>
	    		<contact token="{{ auth()->user()->getToken('elearning-contatc') }}" address="{{ $site->address }}"
	    			id="{{ $page->id }}" ></contact>
	    	</v-flex>
		@elseif($page->title == 'Sign Up')
			<v-flex xs12>
	    		<h1 class="headline">Signed Up Users</h1>
	    		<v-divider></v-divider>
	    		<sign-up token="{{ auth()->user()->getToken('elearning-signUp') }}" address="{{ $site->address }}"
	    			id="{{ $page->id }}"></sign-up>
	    	</v-flex>
		@elseif($page->title == 'Courses')
			<v-flex xs12>
	    		<h1 class="headline">{{$page->title}}</h1>
	    		<v-divider></v-divider>
	    		<courses token="{{ auth()->user()->getToken('elearning-signUp') }}" address="{{ $site->address }}"
	    			id="{{ $page->id }}"></courses>
	    	</v-flex>
	    @endif
	</v-layout>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.dashboard._includes.layout-script')
@stop