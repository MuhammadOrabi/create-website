<?php

namespace App\Http\Controllers;

use App\Page;
use App\Section;
use Illuminate\Http\Request;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;
use App\Helpers\Portfolios\PortfoliosHelper;
use App\Helpers\Blogs\BlogsHelper;

class SectionController extends Controller
{
    public function store()
    {
        if (request()->ajax()) {
            $page = Page::findOrFail(request()->id);
            $site = $page->site;
            $tag = $page->site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                if (auth()->id() === $site->user->id) {
                    $data = WebAppsHelper::finder($site, $page, 'create-section-auth', request()->all());
                } else {
                    $data = WebAppsHelper::finder($site, $page, 'createSection', request()->all());
                }
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
                if (auth()->id() === $site->user->id) {
                    $data = BlogsHelper::finder($site, $page, 'create-section-auth', request()->all());
                }
            }
        } else {
            $page = Page::findOrFail(request()->id);
            $site = $page->site;
            $tag = $page->site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $this->validate(request(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'message' => 'required',
                ]);
                $data = WebsitesHelper::finder($site, $page, 'createSection', request()->all());
                return back();
            } elseif ($tag->tag === 'portfolio') {
                $this->validate(request(), [
                    'name' => 'required',
                    'subject' => 'required',
                    'email' => 'required|email',
                    'message' => 'required',
                ]);
                $data = PortfoliosHelper::finder($site, $page, 'create-section-site', request()->all());
                return back();
            } elseif ($tag->tag === 'web application') {
            } elseif ($tag->tag === 'blog') {
                BlogsHelper::finder($site, $page, 'create-section-site', request()->all());
                return back();
            }
        }
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
            $data = PortfoliosHelper::finder($section->page->site, $section->page, 'getSection', null, $section);
            return response()->json($data);
        } elseif ($tag->tag === 'web application') {
            $data = WebAppsHelper::finder($section->page->site, $section->page, 'getSection', null, $section);
            return response()->json($data);
        } elseif ($tag->tag === 'blog') {
            $data = BlogsHelper::finder($section->page->site, $section->page, 'getSection', null, $section);
            return response()->json($data);
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
            $data = PortfoliosHelper::finder($site, $section->page, 'updateSection', request()->all(), $section);
            return response()->json($data);
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


    public function destroy()
    {
        if (request()->ajax()) {
            $section = Section::findOrFail(request()->id);
            $site = auth()->user()->sites()->findOrFail($section->page->site->id);
            $tag = $section->page->site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                $data = WebsitesHelper::finder($section->page->site, $section->page, 'deleteSection', null, $section);
                return response()->json($data);
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
                $data = WebAppsHelper::finder($section->page->site, $section->page, 'deleteSection', null, $section);
                return response()->json($data);
            } elseif ($tag->tag === 'blog') {
                $data = BlogsHelper::finder($section->page->site, $section->page, 'deleteSection', null, $section);
                return response()->json($data);
            }
        } else {
            $section = Section::findOrFail(request()->id);
            $site = auth()->user()->sites()->findOrFail($section->page->site->id);
            $tag = $section->page->site->theme->tags()->where('type', 'category')->first();
            if ($tag->tag === 'website') {
                WebsitesHelper::finder($section->page->site, $section->page, 'deleteSection', null, $section);
                return back();
            } elseif ($tag->tag === 'portfolio') {
            } elseif ($tag->tag === 'web application') {
            } elseif ($tag->tag === 'blog') {
            }
        }
    }
}
