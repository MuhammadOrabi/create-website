<?php

namespace App\Http\Controllers;

use App\Page;
use App\Section;
use Illuminate\Http\Request;
use App\Content;

class SectionController extends Controller
{
    public function store()
    {
        $page = Page::findOrFail(request()->id);
        $site = $page->site;
        if ($site->theme->location == 'templates.web-apps.elearning') {
            if ($page->slug == 'news') {
                $news = $page->sections()->create(['title' => 'news', 'order' => 0]);
                $news->contents()->create(['type' => 'heading', 'content' => request('title')]);
                $news->contents()->create(['type' => 'img', 'content' => request('url')]);
                $news->contents()->create(['type' => 'paragraph', 'content' => request('description')]);
                return response()->json(['msg' => 'success', 'news' => compact('news')]);
            } elseif ($page->slug == '' || $page->slug == 'about') {
                $section = $page->sections()->create(['title' => $page->slug, 'order' => 0]);
                $section->contents()->create(['type' => 'heading', 'content' => request('heading')]);
                $section->contents()->create(['type' => 'img', 'content' => request('img')]);
                $section->contents()->create(['type' => 'paragraph', 'content' => request('paragraph')]);
                $section->contents()->create(['type' => 'name', 'content' => request('name')]);
                $section->contents()->create(['type' => 'title', 'content' => request('title')]);
                $section->contents()->create(['type' => 'avatar', 'content' => request('avatar')]);
                $section->contents()->create(['type' => 'facebook', 'content' => request('facebook')]);
                $section->contents()->create(['type' => 'twitter', 'content' => request('twitter')]);
                $section->contents()->create(['type' => 'github', 'content' => request('github')]);
                return response()->json(['msg' => 'success', 'home' => compact('section')]);
            } elseif ($page->slug == 'courses') {
                $section = $page->sections()->create(['title' => request('title')]);
                $section->extras()->create(['type' => 'paragraph', 'content' => request('paragraph')]);
                foreach (request('tags') as $tag) {
                    $section->extras()->create(['type' => 'tag', 'content' => $tag]);
                }
                // $forum = Page::where('slug', 'forum')->first();
                // $courseForum = $forum->sections()->create(['title' => 'Course Forum']);
                // $section->extras()->create(['type' => 'forum', 'content' => $courseForum->id]);
                return response()->json(['msg' => 'success', 'section' => compact('section')]);
            }
        }
        return response(500);
    }

    public function show()
    {
        $section = Section::where('id', request()->id)->with('contents', 'extras', 'page')->first();
        $site = auth()->user()->sites()->where('address', $section->page->site->address)->with('pages')->first();
        if (!$site) {
            return back();
        }
        return view($site->theme->location . '.dashboard.sections.show', compact('site', 'section'));
    }

    public function showAPI()
    {
        $section = Section::where('id', request()->id)->with('contents.extras', 'extras', 'page')->first();
        if (!$section) {
            return response()->json(500);
        }
        return response()->json(compact('section'), 200);
    }

    public function update()
    {
        $section = Section::findOrFail(request()->id);
        $site = auth()->user()->sites()->where('address', $section->page->site->address)->first();
        if (!$site) {
            return response()->json('err', 500);
        }
        $contents = $section->contents->toArray();
        return response()->json($contents);
    }

    public function editExtras()
    {
        $section = Section::findOrFail(request()->id);
        $section->title = request('title');
        $section->save();
        $section->extras()->where('type', 'paragraph')->update(['content' => request('paragraph')]);
        $section->extras()->where('type', 'tag')->delete();
        foreach (request('tags') as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }
        return response()->json(['msg' => 'success', 'section' => compact('section')]);
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
        $section = Section::findOrFail(request()->id);
        $section->contents()->each(function ($content) {
            $content->extras()->delete();
            $content->delete();
        });
        $section->extras()->delete();
        $section->delete();
        return back();
    }

    public function destroyAPI()
    {
        $section = Section::findOrFail(request()->id);
        $section->contents()->each(function ($content) {
            $content->extras()->delete();
            $content->delete();
        });
        $section->extras()->delete();
        $section->delete();
        return response()->json('success');
    }
}
