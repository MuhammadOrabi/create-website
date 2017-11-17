@extends('layouts.vuetify')

@section('title')
	{{ $section->title }} - Create Website
@stop

@php
	$tags = $section->extras->where('type', 'tag')->all();
	$paragraph = $section->extras->where('type', 'paragraph')->first();
@endphp

@section('content')
	<v-container >
		<create-update-course token="{{ auth()->user()->getToken('Create-Course') }}" address="{{ $site->address }}"
			id="{{ $section->page->id }}" operation="update" sectionId="{{ $section->id }}"></create-update-course>
		<section class="grey darken-1">
			<v-container>
	         	<v-card class="transparent elevation-0 white--text">
	         		<v-card-title class="display-3">{{ $section->title }}</v-card-title>
	         		<v-card-text>{{ $paragraph->content }}</v-card-text>
	         		<br>
	         		<v-card-text>
	         			@foreach($tags as $tag)
         					<v-chip label class="mr-5">{{ $tag->content }}</v-chip>
         				@endforeach
	         		</v-card-text>
	         	</v-card>
	        </v-container>
		</section>
		<section>
			<v-layout row>
				<v-flex sm6 offset-sm1 class="pt-3">
					<v-card class="transparent elevation-0" >
						<v-list three-line>
				          <template>
				          	@foreach($section->contents as $content)
					            <v-list-tile avatar>
					              	<v-list-tile-avatar>
					                	<v-chip label>{{ $loop->index }}</v-chip>
					              	</v-list-tile-avatar>
					              	<v-list-tile-content>
					                	<v-list-tile-sub-title>Lesson {{ $loop->index }}</v-list-tile-sub-title>
					                	<v-list-tile-title v-if="i == 1">Adding Our First Controller</v-list-tile-title>
					                	<v-list-tile-title v-else>Installing Laravel and Composer</v-list-tile-title>
					              	</v-list-tile-content>
					            </v-list-tile>
				            @endforeach
				          </template>
				        </v-list>
					</v-card>
				</v-flex>
			</v-layout>
		</section>
	</v-container>
@stop

@section('scripts')
	<script type="text/javascript" src="/js/templates/web-apps/elearning/app.js"></script>
	@include($site->theme->location . '.dashboard._includes.layout-script')
@stop