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
        $section_b = $home->sections()->create(['title' => 'section_b', 'order' => 2]);
        $section_a = $home->sections()->create(['title' => 'section_a', 'order' => 3]);
        $section_c = $home->sections()->create(['title' => 'section_c', 'order' => 4]);

        $about = $site->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $aboutSection = $about->sections()->create(['title' => 'aboutSection', 'order' => 1]);

        $services = $site->addPage(['title' => 'Services', 'homePage' => false, 'slug' => 'services']);
        $servicesSection = $services->sections()->create(['title' => 'servicesSection', 'order' => 1]);

        $top_nav = $site->constants()->create(['type' => 'top-nav']);

        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
    }

    public static function doThis($op, $data)
    {
        if ($op === 'createOrUpdateContent') {
            $bizlight = new BizlightContentHelper;
            return $bizlight->createOrUpdate($data);
        } elseif ($op === 'showSite') {
            $site = new BizlightSiteHelper($data['id']);
            return $site->showSlug($data);
        }
    }
}
