@extends($site->theme->location . '.dashboard.layout')

@section('content')
    <div class="container">
    	<h1>Navigation</h1>
		<hr>
		<navigation address="{{ $site->address }}" token="{{ auth()->user()->getToken('Navigation') }}"></navigation>
    </div>
@stop