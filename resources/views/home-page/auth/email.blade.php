@extends('layouts.materialize')

@section('title')
	Reset Password - Create Website
@stop

@section('content')
	@include('home-page._includes.nav.toolbar')
	<div class="container z-depth-5" style="margin-top: 20px">
	    <div class="row">
	        <div class="col s10 offset-s1">
	            <div class="section">
                	<h4 class="card-title center-align">Login</h4>
                	@if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form class="form-group" role="form" method="POST" action="{{ route('password.email') }}">
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
                            <div class="input-field center-align">
								<button class="btn waves-effect waves-light" type="submit" name="action">Send Password Reset Link</button><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
	</div>
@endsection
