<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;

class PageController extends Controller
{
	public function index() {
		$site = Site::where('user_id', auth()->id())->where('address', request()->address)
					->with('constants.contents', 'imgs', 'theme', 'extras')->first();

		$pages = ['navigation', 'media', 'settings', 'analytics'];
		if (!$site || !in_array(request()->type, $pages)) {
			return redirect()->route('home');
		}
		
		$view = $site->theme->location . '.dashboard.' . request()->type;
		if (!view()->exists($view)) {
			return redirect()->route('home');
		}
		return view($view, compact('site'));
	}

	public function edit() {
		$page = Page::where('id', request()->id)->with('sections.contents')->first();
		$site = Site::where('id', $page->site->id)->with('user', 'theme', 'pages')->first();
		if (!$page || auth()->id() != $site->user->id) {
			return redirect()->home();
		}
		return view($site->theme->location . '.dashboard.pages.show', compact('page', 'site'));
	}

	public function show() {
	    $page = Page::where('id', request()->id)->with('sections.extras')->first();
	    return response()->json(compact('page'), 200);
	}
}
