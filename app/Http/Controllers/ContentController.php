<?php

namespace App\Http\Controllers;

use App\Content;
use App\Section;
use Illuminate\Http\Request;

class ContentController extends Controller
{
	public function store() {
	    $section = Section::findOrFail(request()->id);
	    $site = auth()->user()->sites()->where('address', $section->page->site->address)->first();
	    if ($site) {
		    if ($site->theme->location == 'templates.web-apps.elearning') {
				$content = $section->contents()->create(['type' => 'lesson', 'title' => request('title'), 'content' => request('paragraph')]);
				$content->extras()->create(['type' => 'video', 'content' => request('video')]);
				$content->extras()->create(['type' => 'files', 'content' => request('files')]);
				return response()->json('success', 200);
		    }
	    } else {
	    	return response(400);
	    }
	}

    public function update() {
        $data = request()->all();
        foreach ($data as $update) {
        	$content = Content::findOrFail($update['id']);
        	$content->content = $update['content'];
        	$content->save();
        }
		return response()->json('success', 200);
    }

    public function updateExtras() {
        $content = Content::findOrFail(request()->id);
	    $site = auth()->user()->sites()->where('address', $content->section->page->site->address)->first();
	    if ($site) {
		    if ($site->theme->location == 'templates.web-apps.elearning') {
				$content->title = request('title');
				$content->content = request('paragraph');
				$content->save();
	    		$content->extras()->where('type', 'video')->update(['content' => request('video')]);
	    		$content->extras()->where('type', 'files')->update(['content' => request('files')]);				
				return response()->json('success', 200);
		    }
	    } else {
	    	return response(400);
	    }
    }

    public function show() {
        $content = Content::where('id', request()->id)->with('extras', 'section.contents.extras')->first();
	    $site = $content->section->page->site;
	    if ($site) {
		    if ($site->theme->location == 'templates.web-apps.elearning') {
				return response()->json(compact('content'));
		    }
	    } else {
	    	return response(400);
	    }
    }
}
