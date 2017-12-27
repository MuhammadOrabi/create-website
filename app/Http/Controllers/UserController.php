<?php

namespace App\Http\Controllers;

use App\Mail\ActivateEmail;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Site;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                'email' => Rule::unique('users')->where('address', $request->address)
            ],
            'address' => 'required|string|exists:sites',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(compact('errors'));
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required', 'email', 'max:255',
                'email' => Rule::exists('users')->where('address', request('address'))
            ],
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ['error' => true, 'errors' => $validator->errors(), 'msg' => 'Something went wrong!'];
        }

        $credentials = ['email' => request('email'), 'password' => request('password'), 'address' => request('address')];
        if (auth()->once($credentials)) {
            $user = User::where('email', request('email'))->where('address', request('address'))->first();
            if (!$user->active) {
                return response()->json(['error' => true, 'errors' => null,
                    'msg' => 'You have to active your email, contact us for more information!']);
            }
            return response()->json(['token' => $user->getToken('Sign In'), 'user' => $user]);
        }
        return response()->json(['error' => true, 'msg' => 'Please Check your Credentials!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = User::where('id', request()->user()->id)->where('address', '!=', 'main')
                    ->with(['extras',
                    'logs' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    },
                    'logs.contents.contentable', 'logs.sections'])->first();

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
    public function updateByAdmin()
    {
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

    public function update()
    {
        $user = request()->user();
        $site = Site::where('address', $user->address)->first();
        if ($site->theme->location === 'templates.web-apps.elearning') {
            $user->name = request('name');
            $user->title = request('title');
            if (request('password')) {
                $user->password = Hash::make(request('password'));
                $user->setRememberToken(Str::random(60));
            }
            $user->save();
            $avatar = $user->extras()->where('type', 'avatar')->first();
            if (!$avatar) {
                $avatar = $user->extras()->create(['type' => 'avatar', 'content' => request('avatar')]);
            } else {
                $avatar->content = request('avatar');
                $avatar->save();
            }

            $twitter = $user->extras()->where('type', 'twitter')->first();
            if (!$twitter) {
                $user->extras()->create(['type' => 'twitter', 'content' => request('twitter')]);
            } else {
                $twitter->content = request('twitter');
                $twitter->save();
            }

            $facebook = $user->extras()->where('type', 'facebook')->first();
            if (!$facebook) {
                $user->extras()->create(['type' => 'facebook', 'content' => request('facebook')]);
            } else {
                $facebook->content = request('facebook');
                $facebook->save();
            }

            $github = $user->extras()->where('type', 'github')->first();
            if (!$github) {
                $user->extras()->create(['type' => 'github', 'content' => request('github')]);
            } else {
                $github->content = request('github');
                $github->save();
            }

            return response()->json('success', 200);
        }

        return response(500);
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
