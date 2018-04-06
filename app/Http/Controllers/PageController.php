<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\Portfolios\PortfoliosHelper;
use App\Helpers\Blogs\BlogsHelper;

class PageController extends Controller
{
    public function index()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, request()->type, 'dashboard', null);
        } elseif ($tag->tag === 'portfolio') {
            $data = PortfoliosHelper::finder($site, request()->type, 'dashboard', null);
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, request()->type, 'dashboard', null);
        } elseif ($tag->tag === 'blog') {
            $data = BlogsHelper::finder($site, request()->type, 'dashboard', null);
        }
        abort_if(!view()->exists($data['location']), 404);
        return view($data['location'], $data['data']);
    }

    public function store()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
        } elseif ($tag->tag === 'blog') {
            $data = BlogsHelper::finder($site, null, 'create-page', request()->all());
            return response()->json($data);
        }
    }

    public function edit()
    {
        $site = auth()->user()->sites()->where('address', request()->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
            $info = ['type' => request()->type, 'action' => request()->action];
            $data = PortfoliosHelper::finder($site, null, 'dashboard-load-action', $info, request()->id);
            abort_if(!view()->exists($data['location']), 404);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'web application') {
            $info = ['type' => request()->type, 'action' => request()->action];
            $data = WebAppsHelper::finder($site, null, 'dashboard-load-action', $info, request()->id);
            abort_if(!view()->exists($data['location']), 404);
            return view($data['location'], $data['data']);
        } elseif ($tag->tag === 'blog') {
            $info = ['type' => request()->type, 'action' => request()->action];
            $data = BlogsHelper::finder($site, null, 'dashboard-load-action', $info, request()->id);
            abort_if(!view()->exists($data['location']), 404);
            return view($data['location'], $data['data']);
        }
        abort(404);
    }

    public function update()
    {
        $page = Page::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($page->site->id);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($page->site, $page, 'update-page', request()->all());
            return response()->json($data);
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $page, 'updatePage', request()->all());
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function show()
    {
        if (request()->ajax()) {
            $page = Page::findOrFail(request()->id);
            $site = $page->site;
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if (auth()->user()) {
                abort_if($site->user->id != auth()->id(), 400);
                $op = 'get-page-auth';
            } else {
                $op = 'get-page';
            }
            if ($tag->tag === 'website') {
                return WebsitesHelper::finder($site, $page, $op);
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($site, $page, $op);
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
                $data = BlogsHelper::finder($site, $page, $op);
                return response()->json($data);
            }
        } else {
            $site = auth()->user()->sites()->where('address', request()->address)->firstOrFail();
            $tag = $site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $data = WebsitesHelper::finder($site, intval(request()->id), 'dashboard', request()->type);
                $page = $data['data'][0];
                abort_if(!view()->exists($data['location']), 404);
                return view($data['location'], compact('page', 'site'));
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($site, null, 'dashboard-load-page', request()->type, request()->id);
                abort_if(!view()->exists($data['location']), 404);
                return view($data['location'], $data['data']);
            } elseif ($tag->tag === 'blog') {
                $data = BlogsHelper::finder($site, null, 'dashboard-load-page', request()->type, request()->id);
                abort_if(!view()->exists($data['location']), 404);
                return view($data['location'], $data['data']);
            }
        }
        abort(500);
    }
}
