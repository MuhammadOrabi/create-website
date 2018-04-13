<?php

namespace App\Http\Controllers;

use App\Site;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\Portfolios\PortfoliosHelper;
use App\Helpers\Blogs\BlogsHelper;

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
        return response()->json($site);
    }

    public function show()
    {
        $site = Site::where('address', request()->address)->firstOrFail();
        $slug = request()->slug;
        if (!$slug) {
            // if the homepage slug
            $slug = 'index';
        } else {
            // if the slug doesn't belong to any of the site pages
            abort_if(! $site->pages->pluck('slug')->contains($slug), 404);
        }
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, $slug, 'site', null);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'portfolio') {
            $data = PortfoliosHelper::finder($site, $slug, 'site', request()->id);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $slug, 'site', request()->id);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'blog') {
            $data = BlogsHelper::finder($site, $slug, 'site', request()->id);
            return view($data['location'], $data['data']);
        }
        abort(500);
    }

    public function info()
    {
        $site = Site::where('address', request()->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, null, 'api-info', request()->type);
            return response()->json($data);
        } elseif ($tag->tag === 'portfolio') {
            $data = PortfoliosHelper::finder($site, null, 'api-info', request()->type);
            return response()->json($data);
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, null, 'api-info', request()->type);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            $data = BlogsHelper::finder($site, null, 'api-info', request()->type);
            return response()->json($data);
        }
    }

    public function update()
    {
        if (request()->ajax()) {
            $site = auth()->user()->sites()->findOrFail(request()->id);
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $data = WebsitesHelper::finder($site, null, 'site-update', request()->all());
                return response()->json($data);
            } elseif ($tag->tag === 'portfolio') {
                $data = PortfoliosHelper::finder($site, null, 'site-update', request()->all());
                return response()->json($data);
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($site, null, 'site-update', request()->all());
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
                $data = BlogsHelper::finder($site, null, 'site-update', request()->all());
                return response()->json($data);
            }
        } else {
            $site = auth()->user()->sites()->findOrFail(request()->id);
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $this->validate(request(), [
                    'name' => 'required'
                ]);
                $site->name = request('name');
                $site->save();
                return back();
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
            } elseif ($tag->tag === 'blog') {
            }
        }
    }
}
