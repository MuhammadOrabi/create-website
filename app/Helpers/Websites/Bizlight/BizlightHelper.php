<?php

namespace App\Helpers\Websites\Bizlight;

use App\Site;

class BizlightHelper
{
    public static function scaffold($id)
    {
        $site = Site::findOrFail($id);

        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $showCase = $home->sections()->create(['title' => 'showCase', 'order' => 1]);
        $showCase->contents()->create(['type' => 'heading']);
        $showCase->contents()->create(['type' => 'paragraph']);

        $section_b = $home->sections()->create(['title' => 'section_b', 'order' => 2]);
        $section_b->contents()->create(['type' => 'heading', 'order' => 1]);
        $section_b->contents()->create(['type' => 'paragraph', 'order' => 1]);
        $section_b->contents()->create(['type' => 'heading', 'order' => 2]);
        $section_b->contents()->create(['type' => 'paragraph', 'order' => 2]);
        $section_b->contents()->create(['type' => 'heading', 'order' => 3]);
        $section_b->contents()->create(['type' => 'paragraph', 'order' => 3]);
        $section_b->contents()->create(['type' => 'img']);

        $section_a = $home->sections()->create(['title' => 'section_a', 'order' => 3]);
        $section_a->contents()->create(['type' => 'heading', 'order' => 1]);
        $section_a->contents()->create(['type' => 'paragraph', 'order' => 1]);
        $section_a->contents()->create(['type' => 'img', 'order' => 1]);
        $section_a->contents()->create(['type' => 'heading', 'order' => 2]);
        $section_a->contents()->create(['type' => 'paragraph', 'order' => 2]);
        $section_a->contents()->create(['type' => 'img', 'order' => 2]);
        $section_a->contents()->create(['type' => 'heading', 'order' => 3]);
        $section_a->contents()->create(['type' => 'paragraph', 'order' => 3]);
        $section_a->contents()->create(['type' => 'img', 'order' => 3]);

        $section_c = $home->sections()->create(['title' => 'section_c', 'order' => 4]);
        $section_c->contents()->create(['type' => 'paragraph']);
        $section_c->contents()->create(['type' => 'img']);

        $about = $site->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $aboutSection = $about->sections()->create(['title' => 'aboutSection', 'order' => 1]);
        $aboutSection->contents()->create(['type' => 'paragraph']);

        $services = $site->addPage(['title' => 'Services', 'homePage' => false, 'slug' => 'services']);
        $servicesSection = $services->sections()->create(['title' => 'servicesSection', 'order' => 1]);
        $servicesSection->contents()->create(['type' => 'heading', 'order' => 1]);
        $servicesSection->contents()->create(['type' => 'paragraph', 'order' => 1]);
        $servicesSection->contents()->create(['type' => 'heading', 'order' => 2]);
        $servicesSection->contents()->create(['type' => 'paragraph', 'order' => 2]);
        $servicesSection->contents()->create(['type' => 'heading', 'order' => 3]);
        $servicesSection->contents()->create(['type' => 'paragraph', 'order' => 3]);

        $top_nav = $site->constants()->create(['type' => 'top-nav']);
        $top_nav->contents()->create(['type' => 'twitterLink']);
        $top_nav->contents()->create(['type' => 'facebookLink']);
        $top_nav->contents()->create(['type' => 'googleLink']);
        $top_nav->contents()->create(['type' => 'linkedinLink']);

        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
    }
}
