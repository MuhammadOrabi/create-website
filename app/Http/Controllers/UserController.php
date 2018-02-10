<?php

namespace App\Http\Controllers;

use App\Site;
use App\User;
use App\Mail\ActivateEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\WebApps\WebAppsHelper;
use Illuminate\Support\Facades\Validator;

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
        $site = Site::where('address', request()->address)->firstOrFail();
        $user = User::find(request()->id);
        abort_if($site->address != $user->address, 500);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            return WebAppsHelper::finder($site, null, 'user-info', null, $user);
        } elseif ($tag->tag === 'blog') {
        }
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
                if (request()->option === '1') {
                    $activate = $user->activate ? $user->activate : $user->activate()->create(['code' => str_random(40)]);
                    $activate->save();
                    \Mail::to($user)->send(new activateMail($user));
                } elseif (request()->option === '2') {
                    $user->active = 1;
                    $user->save();
                } elseif (request()->option === '3') {
                    $user->active = 0;
                    $user->save();
                } elseif (request()->option === '4') {
                    $user->delete();
                }
            } else {
                return response()->json('error');
            }
        }
        return response()->json('success');
    }

    public function update()
    {
        $user = User::findOrFail(request()->id);
        $site = Site::where('address', $user->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            return WebAppsHelper::finder($site, null, 'user-update', request()->all(), $user);
        } elseif ($tag->tag === 'blog') {
        }
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
