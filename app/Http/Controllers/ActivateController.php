<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Mail\ActivateEmail;

class ActivateController extends Controller
{
    public function active(Request $request)
    {
        $user = User::find($request->id);
        if (!$user->activate) {
            return redirect('/');
        }
        if ($user->activate->code == $request->code) {
            $user->activate->delete();
            $user->active = 1;
            $user->save();
            $user->logs()->create(['type' => 'user_auth', 'action' => 'User Activate Email']);
        }
        return redirect()->home();
    }

    public function resend(Request $request)
    {
        $user = User::find($request->id);
        $user->logs()->create(['type' => 'user_auth', 'action' => 'User Request to Activate Email']);
        $user->activate()->update(['code' => str_random(40)]);
        \Mail::to($user)->send(new ActivateEmail($user));
        return back();
    }
}
