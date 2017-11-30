<?php

namespace App\Http\Controllers;

use App\Content;
use App\Section;
use Illuminate\Http\Request;
use App\Extra;

class ContentController extends Controller
{
    public function store()
    {
        $section = Section::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $section->page->site->address)->first();
        if ($site) {
            if ($site->theme->location == 'templates.web-apps.elearning') {
                $content = $section->contents()->create(['type' => 'lesson', 'title' => request('title'), 'content' => request('paragraph')]);
                $content->extras()->create(['type' => 'video', 'title' => request('fileName'), 'content' => request('video')]);
                return response()->json('success', 200);
            }
        } else {
            return response(400);
        }
    }

    public function update()
    {
        $data = request()->all();
        foreach ($data as $update) {
            $content = Content::findOrFail($update['id']);
            $content->content = $update['content'];
            $content->save();
        }
        return response()->json('success', 200);
    }

    public function updateExtras()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $content->section->page->site->address)->first();
        if ($site) {
            if ($site->theme->location == 'templates.web-apps.elearning') {
                if (request('title') && request('paragraph')) {
                    $content->title = request('title');
                    $content->content = request('paragraph');
                    $content->save();
                } elseif (request('video')) {
                    $content->extras()->where('type', 'video')->update(['content' => request('video')]);
                }
                return response()->json('success', 200);
            }
        } else {
            return response(400);
        }
    }

    public function show()
    {
        $content = Content::where('id', request()->id)->with('extras', 'section.contents.extras')->first();
        $site = $content->section->page->site;
        if ($site) {
            if ($site->theme->location == 'templates.web-apps.elearning') {
                return response()->json(compact('content'));
            }
        } else {
            return response(400);
        }
    }

    public function destroy()
    {
        $content = Content::where('id', request()->id)->first();
        Extra::where('content_id', $content->id)->delete();
        $content->delete();
        return response($content->id);
    }
}
