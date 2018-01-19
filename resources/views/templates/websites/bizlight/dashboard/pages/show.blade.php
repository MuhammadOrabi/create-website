@extends($site->theme->location . '.dashboard.layout')

@section('content')
    <div class="container">
	@php
	@endphp
		<h1>{{ $page->title }}</h1>
		<hr>
		@if($page->slug == '')
			<home-page	token="{{ auth()->user()->getToken('') }}"
					address="{{ $site->address }}" page="{{ $page->id }}"
					showcase="{{ $page->sections->where('title', 'showCase')->first()->id }}" 
					sectiona="{{ $page->sections->where('title', 'section_a')->first()->id }}"
					sectionb="{{ $page->sections->where('title', 'section_b')->first()->id }}"
					sectionc="{{ $page->sections->where('title', 'section_c')->first()->id }}" ></home-page>
		@elseif($page->slug == 'about')
			<about token="{{ auth()->user()->getToken('') }}" id="{{ $page->sections->first()->id }}"
				   page="{{ $page->id }}"	address="{{ $site->address }}"></about>
		@elseif($page->slug == 'services')
			<services token="{{ auth()->user()->getToken('') }}" id="{{ $page->sections->first()->id }}" 
					  page="{{ $page->id }}" address="{{ $site->address }}"></services>
		@elseif($page->slug == 'contact')
			<table class="table table-hover">
				<thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Name</th>
			      <th scope="col">E-mail</th>
			      <th scope="col">Date</th>
			      <th scope="col"></th>
			    </tr>
				</thead>
				<tbody>
					@foreach($page->sections as $section)
					    <tr>
					      	<th scope="row">{{ $section->id }}</th>
					      	<td>{{ $section->contents->where('type', 'name')->first()->content }}</td>
					      	<td>{{ $section->contents->where('type', 'email')->first()->content }}</td>
					      	<td>{{ $section->contents->where('type', 'name')->first()->created_at->diffForHumans() }}</td>
					      	<td>
					      		<form action="/section/{{ $section->id }}" method="POST" >
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
						      		<button type="button" class="btn btn-primary" 
						      			data-toggle="modal" data-target="#messageModal{{ $section->id }}">Read</button>
									<button type="submit" class="btn btn-danger">Delete</button>
								</form>
					      	</td>
							@include($site->theme->location . '.dashboard._includes.message-modal')
					    </tr>
				    @endforeach
				</tbody>
			</table>
		@endif
    </div>
@stop