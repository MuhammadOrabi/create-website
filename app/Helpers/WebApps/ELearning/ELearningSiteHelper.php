<?php

namespace App\Helpers\WebApps\ELearning;

use App\Page;
use App\Site;
use App\Content;
use App\Section;

class ELearningSiteHelper
{
    private $site;

    public function __construct($id)
    {
        $this->site = Site::findOrFail($id);
    }

    public function site($slug, $id)
    {
        abort_if(
            !in_array($slug, ['course', 'profile', 'lesson', 'article']) && $id,
            404
        );
        if ($slug === 'index') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = ['site' => $this->site, 'slug' => $slug];
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
        $pages = $this->sidebar();
        $location = $this->site->theme->location . '.dashboard.' . $page;
        $data = ['site' => $this->site, 'pages' => $pages];
        return compact('location', 'data');
    }

    public function loadSection($data, $component)
    {
        $pages = $this->sidebar();
        if ($data === 'pages') {
            $page = $pages->where('id', $component)->first();
            if (!$page) {
                abort(404);
            }
            $page->load('sections.contents');
            $section = null;
        } elseif ($data === 'lessons') {
            $page = $pages->where('slug', 'courses')->first();
            $section = $page->sections()->findOrFail($component);
        }
        $location = $this->site->theme->location . '.dashboard.' . $data . '.show';
        $data = ['page' => $page, 'site' => $this->site, 'pages' => $pages, 'section' => $section];
        return compact('location', 'data');
    }

    public function loadAction($data, $component)
    {
        if ($data['action'] === 'create') {
            if ($data['type'] === 'lessons') {
                return $this->loadCreateLesson($data, $component);
            } elseif ($data['type'] === 'articles') {
                return $this->loadCreateArticles($data, $component);
            }
        } elseif ($data['action'] === 'update') {
            if ($data['type'] === 'lessons') {
                return $this->loadUpdateLesson($data, $component);
            } elseif ($data['type'] === 'articles') {
                return $this->loadUpdateArticles($data, $component);
            }
        }
        abort(404);
    }

    public function loadCreateLesson($data, $component)
    {
        $pages = $this->sidebar();
        $courses = $pages->where('slug', 'courses')->first();
        $section = $courses->sections()->findOrFail($component);
        $location = $this->site->theme->location . '.dashboard.' . $data['type'] . '.' . $data['action'];
        $data = ['page' => $courses, 'site' => $this->site, 'pages' => $pages, 'section' => $section];
        return compact('location', 'data');
    }

    public function loadUpdateLesson($data, $component)
    {
        $pages = $this->sidebar();
        $courses = $pages->where('slug', 'courses')->first();
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
        return $pages;
    }

    public function apiInfo($type)
    {
        if ($type === 'nav') {
            return $this->site->load('extras');
        }
    }
}
