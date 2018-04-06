<?php

namespace App\Helpers\Blogs\Template1;

class Template1SiteHelper
{
    public function __construct($site)
    {
        $this->site = $site;
    }

    public function site($slug, $id)
    {
        if ($slug === 'index') {
            $page = $this->site->pages()->where('homePage', true)->first();
        } else {
            $page = $this->site->pages()->where('slug', $slug)->firstOrFail();
            abort_if(!$id, 404);
        }
        $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
        $page->load('sections.extras', 'sections.contents');
        $location = $this->site->theme->location . '.site.' . $slug;
        $data = ['site' => $this->site, 'slug' => $slug, 'page' => $page];
        return compact('location', 'data');
    }

    public function dashboard($page, $data = null, $component = null)
    {
        $pages = ['media', 'settings', 'analytics', 'footer'];
        abort_if(!in_array($page, $pages), 404);
        $pages = $this->site->pages;
        $location = $this->site->theme->location . '.dashboard.' . $page;
        $data = ['site' => $this->site, 'pages' => $pages];
        return compact('location', 'data');
    }


    public function loadPage($data, $component)
    {
        $pages = $this->site->pages;
        if ($data === 'pages') {
            $page = $pages->where('id', $component)->first();
            abort_if(!$page, 500);
            $page->load('sections.contents');
            $section = null;
        } elseif ($data === 'items') {
            $page = $pages->where('slug', 'pages')->first();
            $section = $page->sections()->findOrFail($component);
        }
        $location = $this->site->theme->location . '.dashboard.' . $data . '.show';
        $data = ['page' => $page, 'site' => $this->site, 'pages' => $pages, 'section' => $section];
        return compact('location', 'data');
    }

    public function loadAction($data, $component)
    {
        if ($data['action'] === 'create') {
            if ($data['type'] === 'items') {
                return $this->loadCreateItems($data, $component);
            }
        } elseif ($data['action'] === 'update') {
            if ($data['type'] === 'items') {
                return $this->loadUpdateItems($data, $component);
            }
        }
        abort(404);
    }

    public function loadCreateItems($data, $component)
    {
        $pages = $this->site->pages;
        $courses = $pages->where('slug', 'pages')->first();
        $section = $courses->sections()->findOrFail($component);
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = ['page' => $courses, 'site' => $this->site, 'pages' => $pages, 'section' => $section];
        return compact('location', 'data');
    }

    public function loadUpdateItems($data, $component)
    {
        $pages = $this->site->pages;
        $courses = $pages->where('slug', 'pages')->first();
        $content = Content::where('id', $component)
                            ->whereIn('contentable_id', $courses->sections->pluck('id'))
                            ->firstOrFail();
        $page = $content->contentable->page;
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = [
            'page' => $page, 'site' => $this->site,
            'pages' => $pages, 'section' => $content->contentable,
            'content' => $content
        ];
        return compact('location', 'data');
    }

    public function apiInfo($type)
    {
        if ($type === 'site-info') {
            return $this->site->load('extras');
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
        return $this->site;
    }
}
