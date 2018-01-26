<?php

namespace App\Http\Controllers;

use App\Page;
use App\Section;
use Illuminate\Http\Request;
use App\Content;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;

class SectionController extends Controller
{
    public function store()
    {
        $page = Page::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($page->site->id);
        $tag = $page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($site, $page, 'createSection', request()->all());
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
        abort(404);
    }

    public function edit()
    {
        $section = Section::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($section->page->site->id);
        $tag = $section->page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder($section->page->site, $section->page, 'getSection', null, $section);
            return response()->json($data);
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($section->page->site, $section->page, 'getSection', null, $section);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function show()
    {
        $section = Section::findOrFail(request()->id);
        $site = $section->page->site;
        $tag = $section->page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($section->page->site, $section->page, 'get-section-site', null, $section);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }


    public function update()
    {
        $section = Section::findOrFail(request()->id);
        $site = auth()->user()->sites()->findOrFail($section->page->site->id);
        $tag = $section->page->site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            $data = WebsitesHelper::finder(
                $site,
                $section->page,
                'updateSection',
                request()->all(),
                $section
            );
            return response()->json($data);
        } elseif ($tag->tag === 'portfolio') {
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder(
                $site,
                $section->page,
                'updateSection',
                request()->all(),
                $section
            );
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
        }
    }

    public function message()
    {
        $page = Page::findOrFail(request()->id);
        $site = $page->site;
        if ($page->slug == 'contact' && $site->theme->location == 'templates.websites.bizlight') {
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ]);
            $msg = $page->sections()->create(['title' => 'msg', 'order' => 0]);
            $msg->contents()->create(['type' => 'name', 'content' => request('name')]);
            $msg->contents()->create(['type' => 'email', 'content' => request('email')]);
            $msg->contents()->create(['type' => 'message', 'content' => request('message')]);
            return back();
        } elseif ($page->slug == 'contact' && $site->theme->location == 'templates.web-apps.elearning') {
            request()->validate([
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ]);
            $msg = $page->sections()->create(['title' => 'msg', 'order' => 0]);
            $msg->contents()->create(['type' => 'name', 'content' => request('name')]);
            $msg->contents()->create(['type' => 'email', 'content' => request('email')]);
            $msg->contents()->create(['type' => 'message', 'content' => request('message')]);
            return response()->json(compact('msg'));
        }
    }

    public function destroy()
    {
        if (request()->ajax()) {
            $section = Section::findOrFail(request()->id);
            $site = auth()->user()->sites()->findOrFail($section->page->site->id);
            $tag = $section->page->site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($section->page->site, $section->page, 'deleteSection', null, $section);
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
            }
        } else {
            $section = Section::findOrFail(request()->id);
            $site = auth()->user()->sites()->findOrFail($section->page->site->id);
            $section->contents()->each(function ($content) {
                $content->extras()->delete();
                $content->delete();
            });
            $section->extras()->delete();
            $section->delete();
            return back();
        }
    }
}
