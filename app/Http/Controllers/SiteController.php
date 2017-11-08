<?php

namespace App\Http\Controllers;

use App\Site;
use Validator;
use Illuminate\Http\Request;

class SiteController extends Controller
{
	public function create() {
		return view('home-page.site-create');
	}

	public function exists() {
		$address = request()->address;
		$site = Site::where('address', $address)->get()->first();
		$feed = 'success';
		if ($site) {
			$feed = 'danger';
		}
		return response()->json($feed);
	}

	public function store() {
		$validator = Validator::make(request()->all(), [
            'address' => 'required|unique:sites|min:5'
        ]);

        if ($validator->fails()) {
           return response()->json('failed', 500);
        }

		$site = auth()->user()->addSite(request('address'), request('theme'));
		$page = $site->pages->first();
		return response()->json(compact('page'));
	}
	public function show() {
	    $site = Site::where('address', request()->address)->with('pages.sections.contents', 'constants.contents')->get()->first();

    	if (!$site) {
    		return redirect()->route('home');
    	}
    	$slug = request()->slug;
    	$idSlugs = array('course', 'lesson', 'forum');
    	
    	if ($slug == 'signin' || $slug == 'signup' || !$slug) {
// if its a webapp authentication
    		$slug = 'index';
    	}else if (!$site->pages->pluck('slug')->contains($slug)) {
// if the slug doesn't belong to any of the site pages 
    		return redirect()->route('site', ['address' => request()->address]);
    	} else if (in_array($slug, $idSlugs)) {
// If the page require an id
    		if (request()->id) {
// if the ID exist
				$id = request()->id;
    		} else {
// If it's not exist
				return redirect()->route('site', ['address' => request()->address]);
    		}
    	} else if (request()->id) {
// if the id given but not required
			return redirect()->route('site', ['address' => request()->address]);
		}

    	$page = $site->pages->where('slug', request()->slug)->first();
    	$nav = $site->constants->where('type', 'top-nav')->first();
    	return view($site->theme->location . '.site.' . $slug, compact('site', 'page', 'nav', 'id'));
	}
}
