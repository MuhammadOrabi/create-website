<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\WebApps\WebAppsHelper;

class PageController extends Controller
{
    public function index()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        $pages = ['navigation', 'media', 'settings', 'analytics'];
        if (!$site || !in_array(request()->type, $pages)) {
            return redirect()->home();
        }

        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, request()->type, 'dashboard', null);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, request()->type, 'dashboard', null);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function edit()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        if (!$site) {
            return redirect()->home();
        }

        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, intval(request()->id), 'dashboard', null);
            $page = $data['data'][0];
            return view($data['location'], compact('page', 'site'));
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, intval(request()->id), 'dashboard', null);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function show()
    {
        $page = Page::where('id', request()->id)->with(['sections' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'sections.contents', 'sections.extras', 'site.user'])->first();
        return response()->json(compact('page'), 200);
    }
}
