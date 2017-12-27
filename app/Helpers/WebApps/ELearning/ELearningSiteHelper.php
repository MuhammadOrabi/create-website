<?php

namespace App\Helpers\WebApps\ELearning;

use App\Site;
use App\Page;

class ELearningSiteHelper
{
    private $site;

    public function __construct($id)
    {
        $this->site = Site::findOrFail($id);
    }

    public function site($slug)
    {
        if ($slug === 'index') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = ['site' => $this->site, 'slug' => $slug];
            return compact('location', 'data');
        } elseif ($slug === 'login' || $slug === 'register') {
            $location = $this->site->theme->location . '.site.auth.' . $slug;
            $data = ['site' => $this->site, 'slug' => $slug];
            return compact('location', 'data');
        } elseif ($this->site->pages()->where('slug', $slug)->first()) {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = ['site' => $this->site, 'slug' => $slug];
            return compact('location', 'data');
        } else {
            $location = $this->site->theme->location . '.site.index';
            $data = ['site' => $this->site, 'slug' => 'index'];
            return compact('location', 'data');
        }
    }

    public function dashboard($page)
    {
        if (is_int($page)) {
            $pages = $this->sidebar();
            $page = $pages->where('id', $page)->first()->load('sections.contents');
            $location = $this->site->theme->location . '.dashboard.pages.show';
            $data = ['page' => $page, 'site' => $this->site, 'pages' => $pages];
            return compact('location', 'data');
        } elseif (is_string($page)) {
            $pages = $this->sidebar();
            $location = $this->site->theme->location . '.dashboard.' . $page;
            $data = ['site' => $this->site, 'pages' => $pages];
            return compact('location', 'data');
        }
    }

    public function sidebar()
    {
        $slugs = ['', 'about', 'news', 'contact', 'courses', 'register'];
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
