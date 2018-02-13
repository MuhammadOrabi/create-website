@extends($site->theme->location . '.dashboard.layout')

@php
    $id = $site->constants()->where('type', 'top-nav')->first()->id;
@endphp
@section('content')
    <div class="container">
    	<h1>Navigation</h1>
		<hr>
		<navigation address="{{ $site->address }}" id="{{ $id }}" token="{{ auth()->user()->getToken('Navigation') }}"></navigation>
    </div>
@stop