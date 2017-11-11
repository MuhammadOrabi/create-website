<?php

namespace App\Http\Controllers;

use App\Page;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
	public function index() {
		$page = Page::where('id', request()->id)->with('sections.contents', 'site.user')->first();
		if ($page->site->user->id != auth()->id()) {
		 	return response()->json('err', 401);
		}
		return response()->json(compact('page'));
	}

	public function store() {
    	$page = Page::findOrFail(request()->id);
    	$site = $page->site;
    	if ($site->theme->name == 'E-Learning') {
	    	if ($page->title == 'News') {
	    		$news = $page->sections()->create(['title' => 'news', 'order' => 0]);
	    		$news->contents()->create(['type' => 'heading', 'content' => request('title')]);
	    		$news->contents()->create(['type' => 'img', 'content' => request('url')]);
	    		$news->contents()->create(['type' => 'paragraph', 'content' => request('description')]);
	    		return response()->json(['msg' => 'success', 'news' => compact('news')]);
	    	} else if ($page->title == 'Home Page' || $page->title == 'About') {
	    		$home = $page->sections()->create(['title' => 'home', 'order' => 0]);
	    		$home->contents()->create(['type' => 'heading', 'content' => request('heading')]);
	    		$home->contents()->create(['type' => 'img', 'content' => request('img')]);
	    		$home->contents()->create(['type' => 'paragraph', 'content' => request('paragraph')]);
	    		return response()->json(['msg' => 'success', 'home' => compact('home')]);
	    	} 
    	}
    	return response(500);
    }
	public function edit() {
		$section = Section::findOrFail(request()->id);
		$site = auth()->user()->sites()->where('address', $section->page->site->address)->first();
		if (!$site) {
			return response()->json('err', 500);
		}
		$contents = $section->contents->toArray();
		return response()->json($contents);
	}
	public function message() {
		$page = Page::findOrFail(request()->id);
		$site = $page->site;
		if ($page->slug == 'contact' && $site->theme->location == 'templates.websites.bizlight') {
			$this->validate(request(), [
				'name' => 'required',
				'email' => 'required|email',
				'message' => 'required',
			]);
			$msg = $page->sections()->create(['title' => 'msg', 'order' => 0]);
			$msg->contents()->create(['type' => 'name', 'content' => request('name')]);
			$msg->contents()->create(['type' => 'email', 'content' => request('email')]);
			$msg->contents()->create(['type' => 'message', 'content' => request('message')]);
			return back();
		} else if ($page->slug == 'contact' && $site->theme->location == 'templates.web-apps.elearning') {
			request()->validate([
				'name' => 'required',
				'email' => 'required|email',
				'message' => 'required',
			]);
			$msg = $page->sections()->create(['title' => 'msg', 'order' => 0]);
			$msg->contents()->create(['type' => 'name', 'content' => request('name')]);
			$msg->contents()->create(['type' => 'email', 'content' => request('email')]);
			$msg->contents()->create(['type' => 'message', 'content' => request('message')]);
			return response()->json(compact('msg'));
		}
	}
	public function destroy() {
        $section = Section::findOrFail(request()->id);
        $section->delete();
        return back();
    }
    public function destroyAPI() {
        $section = Section::findOrFail(request()->id);
        $section->delete();
        return response()->json('success');
    }
}
