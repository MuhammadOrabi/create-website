<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function update() {
        $data = request()->all();
        foreach ($data as $update) {
        	$content = Content::findOrFail($update['id']);
        	$content->content = $update['content'];
        	$content->save();
        }
		return response()->json('success', 200);
    }
}
