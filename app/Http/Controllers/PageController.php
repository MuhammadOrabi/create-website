<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;

class PageController extends Controller
{
    public function index()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        $pages = ['navigation', 'media', 'settings', 'analytics'];
        if (!$site || !in_array(request()->type, $pages)) {
            abort(404);
        }
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ('website' === $tag->tag) {
            $data = WebsitesHelper::finder($site, request()->type, 'dashboard', null);
            return view($data['location'], $data['data']);
        } elseif ('portfolio' === $tag->tag) {
        } elseif ('web application' === $tag->tag) {
            $data = WebAppsHelper::finder($site, request()->type, 'dashboard', null);
            return view($data['location'], $data['data']);
        } elseif ('blog' === $tag->tag) {
        }
    }

    public function edit()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ('website' === $tag->tag) {
        } elseif ('portfolio' === $tag->tag) {
        } elseif ('web application' === $tag->tag) {
            $info = ['type' => request()->type, 'action' => request()->action];
            $data = WebAppsHelper::finder($site, null, 'dashboard-load-action', $info, request()->id);
            abort_if(!view()->exists($data['location']), 404);
            return view($data['location'], $data['data']);
        } elseif ('blog' === $tag->tag) {
        }
    }

    public function update()
    {
        $page = Page::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($page->site->id);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ('website' === $tag->tag) {
        } elseif ('portfolio' === $tag->tag) {
        } elseif ('web application' === $tag->tag) {
            $data = WebAppsHelper::finder($site, $page, 'updatePage', request()->all());
            return response()->json($data);
        } elseif ('blog' === $tag->tag) {
        }
    }

    public function show()
    {
        if (request()->ajax()) {
            $page = Page::findOrFail(request()->id);
            $site = auth()->user()->sites()->findOrFail($page->site->id);
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ('website' === $tag->tag) {
            } elseif ('portfolio' === $tag->tag) {
            } elseif ('web application' === $tag->tag) {
                $data = WebAppsHelper::finder($site, $page, 'getPage');
                return response()->json($data);
            } elseif ('blog' === $tag->tag) {
            }
        } else {
            $site = auth()->user()->sites()->where('address', request()->address)->firstOrFail();
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ('website' === $tag->tag) {
                $data = WebsitesHelper::finder($site, intval(request()->id), 'dashboard', request()->type);
                $page = $data['data'][0];
                abort_if(!view()->exists($data['location']), 404);

                return view($data['location'], compact('page', 'site'));
            } elseif ('portfolio' === $tag->tag) {
            } elseif ('web application' === $tag->tag) {
                $data = WebAppsHelper::finder($site, null, 'dashboard-load-section', request()->type, request()->id);
                abort_if(!view()->exists($data['location']), 404);
                return view($data['location'], $data['data']);
            } elseif ('blog' === $tag->tag) {
            }
        }
    }
}
