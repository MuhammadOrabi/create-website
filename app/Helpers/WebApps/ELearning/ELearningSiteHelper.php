<?php

namespace App\Helpers\WebApps\ELearning;

use App\Page;
use App\Site;
use App\Content;
use App\Section;
use App\Extra;

class ELearningSiteHelper
{
    private $site;

    public function __construct($id)
    {
        $this->site = Site::findOrFail($id);
        $this->site->load('constants');
    }

    public function site($slug, $id)
    {
        abort_if(
            !in_array($slug, ['course', 'profile', 'lesson', 'article']) && $id,
            404
        );
        if ($slug === 'index') {
            $page = $this->site->pages()->where('homePage', true)->first();
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = ['site' => $this->site, 'slug' => $slug, 'page' => $page];
            $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
            return compact('location', 'data');
        } elseif ($slug === 'login' || $slug === 'register') {
            $location = $this->site->theme->location . '.site.auth.' . $slug;
            $data = ['site' => $this->site, 'slug' => $slug];
            return compact('location', 'data');
        } else {
            $page = $this->site->pages()->where('slug', $slug)->firstOrFail();
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = ['site' => $this->site, 'page' => $page, 'slug' => $slug, 'id' => $id];
            return compact('location', 'data');
        }
    }

    public function dashboard($page, $data = null, $component = null)
    {
        $pages = ['media', 'settings', 'analytics', 'footer'];
        abort_if(! in_array($page, $pages), 404);
        $pages = $this->sidebar();
        $location = $this->site->theme->location . '.dashboard.' . $page;
        $data = ['site' => $this->site, 'pages' => $pages];
        return compact('location', 'data');
    }

    public function loadPage($data, $component)
    {
        $pages = $this->sidebar();
        if ($data === 'pages') {
            $page = $pages->where('id', $component)->first();
            abort_if(!$page, 500);
            $page->load('sections.contents');
            $section = null;
        } elseif ($data === 'lessons') {
            $page = $pages->where('slug', 'courses')->first();
            $section = $page->sections()->findOrFail($component);
        } elseif ($data === 'files') {
            $page = $pages->where('slug', 'courses')->first();
            $section = $page->sections()->findOrFail($component);
        } else {
            abort(404);
        }
        $location = $this->site->theme->location . '.dashboard.' . $data . '.show';
        $data = ['page' => $page, 'site' => $this->site, 'pages' => $pages, 'section' => $section];
        return compact('location', 'data');
    }

    public function loadAction($data, $component)
    {
        if ($data['action'] === 'create') {
            if ($data['type'] === 'lessons' || $data['type'] === 'files') {
                return $this->loadCreateCourseItem($data, $component);
            } elseif ($data['type'] === 'articles') {
                return $this->loadCreateArticles($data, $component);
            }
        } elseif ($data['action'] === 'update') {
            if ($data['type'] === 'lessons' || $data['type'] === 'files') {
                return $this->loadUpdateCourseItem($data, $component);
            } elseif ($data['type'] === 'articles') {
                return $this->loadUpdateArticles($data, $component);
            }
        }
        abort(404);
    }

    public function loadCreateCourseItem($data, $component)
    {
        $pages = $this->sidebar();
        $courses = $pages->where('slug', 'courses')->first();
        $section = $courses->sections()->findOrFail($component);
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = ['page' => $courses, 'site' => $this->site, 'pages' => $pages, 'section' => $section];
        return compact('location', 'data');
    }

    public function loadUpdateCourseItem($data, $component)
    {
        $pages = $this->sidebar();
        $courses = $pages->where('slug', 'courses')->first();
        if ($data['type'] === 'lessons') {
            $content = Content::where('id', $component)
                                ->whereIn('contentable_id', $courses->sections->pluck('id'))
                                ->firstOrFail();
            $page = $content->contentable->page;
            $section = $content->contentable;
        } elseif ($data['type'] === 'files') {
            $content = Extra::where('id', $component)
                ->whereIn('extraable_id', $courses->sections->pluck('id'))
                ->firstOrFail();
            $page = $content->extraable->page;
            $section = $content->extraable;
        }
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = [
            'page' => $page, 'site' => $this->site,
            'pages' => $pages, 'section' => $section,
            'content' => $content
        ];
        return compact('location', 'data');
    }

    public function loadCreateArticles($data, $component)
    {
        $pages = $this->sidebar();
        $articles = $pages->where('slug', 'articles')->first();
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = ['page' => $articles, 'site' => $this->site, 'pages' => $pages];
        return compact('location', 'data');
    }

    public function loadUpdateArticles($data, $component)
    {
        $pages = $this->sidebar();
        $articles = $pages->where('slug', 'articles')->first();
        $section = $articles->sections()->findOrFail($component);
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = [
            'page' => $articles, 'site' => $this->site,
            'pages' => $pages, 'section' => $section,
        ];
        return compact('location', 'data');
    }
    

    public function sidebar()
    {
        $slugs = ['', 'about', 'articles', 'contact', 'courses', 'register'];
        $pages = collect($this->site->pages->whereIn('slug', $slugs)->all());
        $pages->where('slug', 'register')->first()->title = 'Users';
        $pages->where('slug', 'contact')->first()->title = 'Messages';
        return $pages;
    }

    public function apiInfo($type)
    {
        if ($type === 'nav') {
            return $this->site->load('extras');
        } elseif ($type === 'site-info') {
            return $this->site->load('user', 'extras');
        } elseif ($type === 'page-analytics') {
            return $this->pageAnalytics();
        }
    }

    public function pageAnalytics()
    {
        $page = $this->site->pages()->where('homePage', true)->first();
        $years = $page->logs->groupBy(
            function ($item, $key) {
                return \Carbon\Carbon::parse($item['created_at'])->year;
            }
        )->toArray();
        $months = $page->logs->groupBy(
            function ($item, $key) {
                $month = \Carbon\Carbon::parse($item['created_at'])->month;
                return date("F", mktime(0, 0, 0, $month, 1));
            }
        )->toArray();
        return ['months' => $months, 'years' => $years];
    }

    public function update($data)
    {
        if ($data['name']) {
            $this->site->update(['name' => $data['name']]);
        }
        if ($data['logo']) {
            $this->site->extras()->updateOrCreate(['type' => 'logo'], ['content' => $data['logo']]);
        }
        return $this->site;
    }

    public function userInfo($user)
    {
        return $user->load('extras');
    }

    public function userUpdate($data, $user)
    {
        $user->title = $data['title'];
        $user->name = $data['name'];
        $user->save();
        if ($data['img']) {
            $user->extras()->updateOrCreate(['type' => 'avatar'], ['content' => $data['img']]);
        }
        return $user;
    }
}
