<?php

namespace App\Helpers\Websites\Bizlight;

use App\Site;
use App\Page;

class BizlightSiteHelper
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
            $data = $this->homePage();
            return compact('location', 'data');
        } elseif ($slug === 'about') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->about();
            return compact('location', 'data');
        } elseif ($slug === 'services') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->services();
            return compact('location', 'data');
        } elseif ($slug === 'contact') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->contact();
            return compact('location', 'data');
        }
    }

    public function dashboard($page, $data = null)
    {
        if (is_int($page)) {
            $page = Page::findOrFail($page);
            $page->load('sections.contents');
            $location = $this->site->theme->location . '.dashboard.' . $data . '.show';
            $site = $this->site;
            $data = collect([$page]);
            return compact('location', 'data');
        } elseif (is_string($page)) {
            $data = ['site' => $this->site];
            $location = $this->site->theme->location . '.dashboard.' . $page;
            return compact('location', 'data');
        }
    }

    public function nav()
    {
        $site = $this->site;
        $nav = $site->constants()->where('type', 'top-nav')->with('contents')->first();
        $links = $nav->contents()->where('type', 'link')->get();
        $logo = $nav->contents()->where('type', 'logo')->first();
        return compact('links', 'logo');
    }

    public function homePage()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('homePage', true)->first();
        $showCase = $page->sections()->where('title', 'showCase')->with('contents')->first();
        $section_b = $page->sections()->where('title', 'section_b')->with('contents')->first();
        $section_a = $page->sections()->where('title', 'section_a')->with('contents')->first();
        $section_c = $page->sections()->where('title', 'section_c')->with('contents')->first();
        return compact('site', 'nav', 'showCase', 'section_b', 'section_a', 'section_c');
    }

    public function about()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('slug', 'about')->first();
        $section = $page->sections()->where('title', 'aboutSection')->with('contents')->first();
        return compact('site', 'nav', 'section');
    }

    public function services()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('slug', 'services')->first();
        $section = $page->sections()->where('title', 'servicesSection')->with('contents')->first();
        return compact('site', 'nav', 'section');
    }

    public function contact()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('slug', 'contact')->first();
        return compact('site', 'nav', 'page');
    }
}
