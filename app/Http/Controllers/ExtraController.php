<?php

namespace App\Http\Controllers;

use App\Content;
use App\Section;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Portfolios\PortfoliosHelper;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\Blogs\BlogsHelper;
use App\Extra;
use App\Site;

class ExtraController extends Controller
{
    public function show()
    {
        $extra = Extra::findOrFail(request()->id);
        $site = $extra->extraable->page->site;
        abort_if($site->address != request()->user()->address, 404);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $extra->extraable->page, 'get-extra-site', null, $extra);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
        return abort(500);
    }

    public function store()
    {
        if (request()->extraable === 'sections') {
            $component = Section::findOrFail(request()->id);
            $page = $component->page;
            $site = auth()->user()->sites()->where('address', $page->site->address)->firstOrFail();
        } elseif (request()->extraable === 'contents') {
            $component = Content::findOrFail(request()->id);
            $page = $component->contentable->page;
            $site = Site::where('address', request()->user()->address)->firstOrFail();
        }
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $page, 'create-extra-' . request()->extraable, request()->all(), $component);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
        return abort(500);
    }

    public function update()
    {
        $extra = Extra::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $extra->extraable->page->site->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $extra->extraable->page, 'update-extra', request()->all(), $extra);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
        return abort(500);
    }

    public function edit()
    {
        $extra = Extra::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($extra->extraable->page->site->id);
        $tag = $extra->extraable->page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $extra->extraable->page, 'get-extra', null, $extra);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function destroy()
    {
        $extra = Extra::findOrFail(request()->id);
        if (request()->extraable === 'sections') {
            $page = $extra->extraable->page;
            $site = auth()->user()->sites()->where('address', $page->site->address)->firstOrFail();
        } elseif (request()->extraable === 'contents') {
            $page = $extra->extraable->contentable->page;
            $site = Site::where('address', request()->user()->address)->firstOrFail();
        }
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $page, 'delete-extra', null, $extra);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }
}
