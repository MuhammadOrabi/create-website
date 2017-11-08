<?php

namespace App\Http\Controllers;

use App\Page;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
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
        $section = Section::find(request()->id);
        $address = $section->page->site->address;
        $section->delete();
        return back();
    }
}
