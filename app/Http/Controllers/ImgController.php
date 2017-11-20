<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ImgController extends Controller
{
    public function index()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        if ($site) {
            $imgs = $site->imgs->toArray();
        } else {
            $user = User::where('id', request()->user()->id)->with('imgs')->first();
            $imgs = $user->imgs;
        }
        return response()->json($imgs);
    }

    public function store()
    {
        $site = auth()->user()->sites()->where('address', request('address'))->first();
        if ($site) {
            $img = $site->addImage(request('img'));
        } else {
            $img = request()->user()->imgs()->create(['url' => request('img')]);
        }
        return response()->json(['msg' => 'success', 'url' => $img->url]);
    }
}
