@extends($site->theme->location . '.dashboard.layout')

@section('content')
    <div class="container">
    	<h1>Settings</h1>
		<hr>
		<div class="m-5">
			<form action="/site/{{ $site->id }}" method="POST" class="form-group">
				{{ method_field('PUT') }}
				{{ csrf_field() }}
				<input type="text" class="form-control" name="name" placeholder="Site Brand" required>
				<div class="form-group p-2">
					<button class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
@stop