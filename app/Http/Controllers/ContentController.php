<?php

namespace App\Http\Controllers;

use App\Content;
use App\Section;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Portfolios\PortfoliosHelper;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\Blogs\BlogsHelper;

class ContentController extends Controller
{
    public function show()
    {
        $content = Content::findOrFail(request()->id);
        $site = $content->contentable->page->site;
        abort_if($site->address != request()->user()->address, 404);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $content->contentable->page, 'get-content-site', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            return BlogsHelper::finder($site, $content->contentable->page, 'get-content-site', request()->all(), $content);
        }
        return abort(500);
    }

    public function store()
    {
        $section = Section::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $section->page->site->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $section->page, 'createContent', request()->all(), $section);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            return BlogsHelper::finder($site, $section->page, 'create-content', request()->all(), $section);
        }
        return abort(500);
    }

    public function update()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $content->contentable->page->site->address)->firstOrFail();
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder(
                $site,
                $content->contentable->page,
                'updateContent',
                request()->all(),
                $content
            );
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            return BlogsHelper::finder($site, $content->contentable->page, 'update-content', request()->all(), $content);
        }
        return abort(500);
    }

    public function edit()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($content->contentable->page->site->id);
        $tag = $content->contentable->page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
            $data = PortfoliosHelper::finder($site, $content->contentable->page, 'get-content', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $content->contentable->page, 'getContent', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            return BlogsHelper::finder($site, $content->contentable->page, 'get-content', request()->all(), $content);
        }
    }

    public function destroy()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($content->contentable->page->site->id);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($site, $content->contentable->page, 'delete-content', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'portfolio') {
            $data = PortfoliosHelper::finder($site, $content->contentable->page, 'delete-content', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $content->contentable->page, 'deleteContent', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            return BlogsHelper::finder($site, $content->contentable->page, 'delete-content', request()->all(), $content);
        }
    }
}
