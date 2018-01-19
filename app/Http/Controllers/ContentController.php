<?php

namespace App\Http\Controllers;

use App\Content;
use App\Section;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;

/**
 * Fully Updated
 */
class ContentController extends Controller
{
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
        }
        return response('Something went wrong!', 500);
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
        }
        return response('Something went wrong!', 500);
    }

    public function edit()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($content->contentable->page->site->id);
        $tag = $content->contentable->page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $content->contentable->page, 'getContent', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function destroy()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($content->contentable->page->site->id);
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $content->contentable->page, 'deleteContent', null, $content);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }
}
