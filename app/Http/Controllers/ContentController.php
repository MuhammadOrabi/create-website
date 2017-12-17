<?php

namespace App\Http\Controllers;

use App\Content;
use App\Section;
use Illuminate\Http\Request;
use App\Helpers\Websites\Bizlight\BizlightHelper;

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
        $site = auth()->user()->sites()->where('address', request()->address)->first();
        if ($site->theme->name === 'bizlight') {
            $msg = BizlightHelper::doThis('createOrUpdateContent', request()->all());
            return response()->json('success');
        }
        return response(500);
    }

    public function updateExtras()
    {
        $content = Content::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $content->contentable->page->site->address)->first();
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
        $content = Content::where('id', request()->id)->with('extras', 'contentable.contents.extras')->first();
        $site = $content->contentable->page->site;
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
        $content->extras()->delete();
        $content->delete();
        return response($content->id);
    }
}
