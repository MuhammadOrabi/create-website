@extends($site->theme->location . '.site.layout')
@section('title')
	Contact |
@stop

@section('content')
	<div class="title-bar">
		<div class="container">
			<h1>Contact Us</h1>
		</div>
	</div>
	<div class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Get In Touch</h4>
						</div>
						<div class="panel-body">
							<form action="/contact/{{ $page->id }}" method="POST">
								{{ csrf_field() }}
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name" placeholder="Enter Name" required="">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email" placeholder="Enter Email" required="">
								</div>
								<div class="form-group">
									<label>Message</label>
									<textarea class="form-control" name="message" placeholder="Enter Message" required=""></textarea>
								</div>
								<div class="text-center">
									<button class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
