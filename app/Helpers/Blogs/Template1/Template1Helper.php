<?php

namespace App\Helpers\Blogs\Template1;

class Template1Helper
{
    public static function scaffold($site)
    {
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $pages = $site->addPage(['title' => 'Pages', 'slug' => 'page']);
        $pages = $site->addPage(['title' => 'Items', 'slug' => 'item']);
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
        } elseif ($op === 'dashboard-load-page') {
            $template1 = new Template1SiteHelper($site);
            return $template1->loadPage($data, $component);
        } elseif ($op === 'getSection') {
            return SectionHelper::which($page, 'get', $data, $component);
        } elseif ($op === 'get-page-auth') {
            return PageHelper::which($page, 'get-auth', $data);
        } elseif ($op === 'create-section-auth') {
            SectionHelper::which($page, 'create-auth', $data);
        } elseif ($op === 'deleteSection') {
            SectionHelper::which($page, 'delete', $data, $component);
        } elseif ($op === 'dashboard-load-action') {
            $template1 = new Template1SiteHelper($site);
            return $template1->loadAction($data, $component);
        } elseif ($op === 'create-content') {
            return ContentHelper::which($page, 'create', $data, $component);
        } elseif ($op === 'get-content') {
            return ContentHelper::which($page, 'get', $data, $component);
        } elseif ($op === 'delete-content') {
            return ContentHelper::which($page, 'delete', $data, $component);
        } elseif ($op === 'update-content') {
            return ContentHelper::which($page, 'update', $data, $component);
        } elseif ($op === 'create-section-site') {
            return SectionHelper::which($page, 'create-comment', $data);
        }
    }
}
