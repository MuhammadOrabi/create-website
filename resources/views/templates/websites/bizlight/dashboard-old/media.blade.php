@extends($site->theme->location . '.dashboard.layout')

@section('content')
    <div class="container">
    	<h1>Media</h1>
		<hr>
		<media address="{{ $site->address }}" token="{{ auth()->user()->getToken('Media') }}"></media>
	</div>
@stop