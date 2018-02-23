<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use Illuminate\Http\Request;

class ImgController extends Controller
{
    public function index()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        if ($site) {
            $imgs = $site->imgs()->with('tags')->get()->toArray();
        } else {
            $user = User::where('id', request()->user()->id)->with('imgs.tags')->first();
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
        foreach (request('labels') as $label) {
            $tag = Tag::firstOrCreate(['tag' => $label]);
            $img->tags()->attach($tag->id);
        }
        return response()->json(['msg' => 'success', 'labels' => $img->tags]);
    }

    public function show()
    {
        $tag = Tag::where('tag', request('tag'))->with('imgs')->get();
        return response()->json($tag);
    }
}
