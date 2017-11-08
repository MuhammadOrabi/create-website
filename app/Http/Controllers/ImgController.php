<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImgController extends Controller
{
    public function index() {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        $imgs = $site->imgs->toArray();
        return response()->json($imgs);
    }

    public function store() {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
    	$img = $site->addImage(request('img'));
    	return response()->json(['msg' => 'success', 'url' => $img->url]);
    }
}
