@extends($site->theme->location . '.dashboard.layout')

@section('content')
    <div class="container">
    	<h1>Navigation</h1>
		<hr>
		<div class="m-5">
			<form action="/const/{{ $site->constants->where('type', 'top-nav')->first()->id }}" method="POST" class="form-group">
				{{ method_field('PUT') }}
				{{ csrf_field() }}
				
				<div class="form-group">
					<input type="text" class="form-control" name="twitter" placeholder="Twitter Link">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="facebook" placeholder="Facebook Link">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="google" placeholder="Google Plus Link">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="linkedin" placeholder="Linked In Link">
				</div>
				<div class="form-group">
					<button class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
    </div>
@stop