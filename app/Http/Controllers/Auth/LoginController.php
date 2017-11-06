<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivateEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function showLoginForm() {
		return view('home-page.auth.login');
	}

	protected function authenticated(Request $request, $user) {
		// PS: Update the if condition to "production" when you have a production mail service
		if (!$user->active && config('env') == 'productions') {
			auth()->logout();
			\Mail::to($user)->send(new ActivateEmail($user));
			return back()->withErrors(['msg' => 'Please check your Email to active your account!']);
		}
	}

	public function credentials() {
        $data = request()->only($this->username(), 'password');
        $data['address'] = 'main';
        return $data;
    }
}
