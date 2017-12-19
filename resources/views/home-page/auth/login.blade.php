@extends('layouts.materialize')

@section('title')
	Login - Create Website
@stop

@section('content')
	@include('home-page._includes.nav.toolbar')
	<div class="container z-depth-5" style="margin-top: 20px">
	    <div class="row">
	        <div class="col s10 offset-s1">
	            <div class="section">
                	<h4 class="card-title center-align">Login</h4>
                    @if ($errors->has('msg'))
                    	<div class="alert alert-danger red-text" role="alert">
						  	{{ $errors->first('msg') }}
						</div>
                    @endif
                    <form class="form-group" role="form" method="POST" action="/login">
                        {{ csrf_field() }}
						<div class="row">
					        <div class="input-field col s12 {{ $errors->has('email') ? ' has-danger' : '' }}">
					          	<input type="email" name="email" id="email" class="validate" value="{{ old('email') }}" required autofocus>
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
                            <div class="input-field center-align">
								<button class="btn waves-effect waves-light" type="submit" name="action">Login</button><br>
                                <a class="" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
	</div>
@endsection
