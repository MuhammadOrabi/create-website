<?php

namespace App\Helpers\Portfolios\Template1;

class Template1Helper
{
    public static function scaffold($site)
    {
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $home->sections()->create(['title' => 'Home']);
        $home->sections()->create(['title' => 'About']);
        $home->sections()->create(['title' => 'Skill']);
        $home->sections()->create(['title' => 'Education']);
        $home->sections()->create(['title' => 'Experience']);
        $home->sections()->create(['title' => 'Contact']);
        $home->sections()->create(['title' => 'Left Show Case']);
        return $site;
    }

    public static function doThis($site, $page, $op, $data, $component)
    {
        if ($op === 'scaffold') {
            return static::scaffold($site);
        } elseif ($op === 'site') {
            $template1 = new Template1SiteHelper($site);
            return $template1->site($page, $data);
        } elseif ($op === 'dashboard') {
            $template1 = new Template1SiteHelper($site);
            return $template1->dashboard($page, $data, $component);
        } elseif ($op === 'dashboard-load-action') {
            $template1 = new Template1SiteHelper($site);
            return $template1->loadAction($data, $component);
        } elseif ($op === 'getSection') {
            return SectionHelper::which('get', $data, $component);
        } elseif ($op === 'updateSection') {
            return SectionHelper::which('update', $data, $component);
        }
    }
}
