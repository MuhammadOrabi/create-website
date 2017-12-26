<?php

namespace App\Http\Controllers;

use App\Site;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\WebApps\WebAppsHelper;

class SiteController extends Controller
{
    public function create()
    {
        return view('home-page.site-create');
    }

    public function exists()
    {
        $address = request()->address;
        $site = Site::where('address', $address)->get()->first();
        $feed = 'success';
        if ($site) {
            $feed = 'danger';
        }
        return response()->json($feed);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'address' => 'required|unique:sites|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json('failed', 500);
        }

        $site = auth()->user()->addSite(request('address'), request('theme'));
        $page = $site->pages->where('homePage', true)->first();
        flash('Congrats for the new site!', ['type' => 'Success']);
        return response()->json(compact('page'));
    }

    public function show()
    {
        $site = Site::where('address', request()->address)->with('pages.sections.contents', 'constants.contents')->first();
        if (!$site) {
            return redirect()->route('home');
        }
        $slug = request()->slug;
        if (!$slug) {
            // if the homepage slug
            $slug = 'index';
        } elseif (!$site->pages->pluck('slug')->contains($slug)) {
            // if the slug doesn't belong to any of the site pages
            return redirect()->route('site', ['address' => request()->address]);
        }

        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, $slug, 'site', null);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $slug, 'site', null);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function info()
    {
        $site = Site::where('address', request()->address)->first();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, null, 'api-info', request()->type);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function update()
    {
        $this->validate(request(), [
            'name' => 'required'
        ]);
        $site = Site::findOrFail(request()->id);
        if ($site->user->id != auth()->id()) {
            return back();
        }
        $site->name = request('name');
        $site->save();
        return back();
    }
}
