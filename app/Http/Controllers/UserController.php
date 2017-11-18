<?php

namespace App\Http\Controllers;

use App\Mail\ActivateEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = request()->user();
	    $site = $user->sites()->where('address', request()->address)->get()->first();
	    $users = User::where('address', $site->address)->orderBy('created_at', 'desc')->get();
	    return response()->json(compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255',
			'address' => 'required|string|exists:sites',
			'password' => 'required|string|min:6|confirmed',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 500);
		}

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'address' => $request->address,
			'password' => bcrypt($request->password),
		]);

		$user->activate()->create(['code' => str_random(40)]);
		// \Mail::to($user)->send(new ActivateEmail($user));

		return response()->json(['token' => $user->getToken('Sign In'), 'user' => $user]); 
	}

	public function login(Request $request) {
		 $validator = Validator::make($request->all(), [
            'email' => [
            	'required','email','max:255',
            	'email' => Rule::exists('users')->where('address', request('address'))
            ],
            'password' => 'required|min:6',
    	]);

    	if ($validator->fails()) {
    		return response()->json(['status' => true, 'errors' => $validator->errors(), 'msg' => 'Try again!' ]);
    	}
		
		$credentials = ['email' => request('email'), 'password' => request('password'), 'address' => request('address') ];
    	if (auth()->once($credentials)) {
	        $user = User::where('email', request('email'))->where('address', request('address'))->first();
    		if (!$user->active) {
        		return response()->json(['status' => true, 'errors' => null, 'msg' => 'Please contact us for more information!']);
	        }
			return response()->json(['token' => $user->getToken('Sign In'), 'user' => $user]);	
    	}
		return response()->json(['status' => true ], 500);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function show() {
		$user = request()->user();
		return response()->json(compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update() {
		$admin = request()->user();
		$site = $admin->sites()->where('address', request()->address)->get()->first();
	    $users = request()->all();
        foreach ($users as $user) {
        	$user = User::find($user['id']);
        	if ($site->address == $user->address) {
        		switch (request()->option) {
        			case '1':
    					$activate = $user->activate ? $user->activate : $user->activate()->create(['code' => str_random(40)]);
						$activate->save();
        				\Mail::to($user)->send(new activateMail($user));
        				break;
        			case '2':
        				$user->active = 1;
        				$user->save();
        				break;
        			case '3':
        				$user->active = 0;
        				$user->save();
        				break;
        			case '4':
        				$user->delete();
        				break;
        		}
        	} else {
				return response()->json('error');
        	}
        }
		return response()->json('success');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		//
	}
}
