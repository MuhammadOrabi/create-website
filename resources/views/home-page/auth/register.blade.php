@extends('layouts.materialize')

@section('title')
	Register - Create Website
@stop

@section('content')
	@include('home-page._includes.toolbar')
	<div class="container z-depth-5" style="margin-top: 20px">
	    <div class="row">
	        <div class="col s10 offset-s1">
	            <div class="section">
                	<h4 class="card-title center-align">Register</h4>
                    @if ($errors->has('msg'))
                    	<div class="alert alert-danger red-text" role="alert">
						  	{{ $errors->first('msg') }}
						</div>
                    @endif
                    <form class="form-group" role="form" method="POST" action="/register">
                        {{ csrf_field() }}
						<div class="row">
					        <div class="input-field col s12 {{ $errors->has('name') ? ' has-danger' : '' }}">
					          	<input type="text" name="name" id="name" class="validate" value="{{ old('name') }}" required autofocus>
					          	<label for="name">Name</label>
					        </div>
					         @if ($errors->has('name'))
					         	<div class="offset-s1">
					        		<span class="red-text">{{ $errors->first('name') }}</span>
					         	</div>
					        @endif
				      	</div>
				      	<div class="row">
					        <div class="input-field col s12 {{ $errors->has('email') ? ' has-danger' : '' }}">
					          	<input type="email" name="email" id="email" class="validate" value="{{ old('email') }}" required>
					          	<label for="email">Email</label>
					        </div>
					         @if ($errors->has('email'))
					         	<div class="offset-s1">
					        		<span class="red-text">{{ $errors->first('email') }}</span>
					         	</div>
					        @endif
				      	</div>
						<div class="row">
					        <div class="input-field col s12 {{ $errors->has('password') ? ' has-danger' : '' }}">
					          	<input id="password" type="password" class="validate" name="password" value="{{ old('password') }}" required>
					          	<label for="password">Password</label>
					        </div>
					        @if ($errors->has('password'))
					        	<div class="red-text">{{ $errors->first('password') }}</div>
					        @endif
						</div>
						<div class="row">
					        <div class="input-field col s12">
					          	<input id="password_confirmation" type="password" class="validate" name="password_confirmation" required>
					          	<label for="password_confirmation">Confirm Password</label>
					        </div>
						</div>
                        <div class="row">
                            <div class="input-field center-align">
								<button class="btn waves-effect waves-light" type="submit" name="register">Register</button><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
	</div>
@endsection
