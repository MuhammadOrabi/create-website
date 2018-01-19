<?php

namespace App\Helpers\Websites\Bizlight;

class SectionHelper
{
    public static function which($page, $op, $data = null, $section = null)
    {
        if ($page->slug === 'about') {
            return AboutHelper::index($page, $op, $data, $section);
        } elseif ($page->slug === 'services') {
            return ServicesHelper::index($page, $op, $data, $section);
        } elseif ($page->homePage) {
            return HomePageHelper::index($page, $op, $data, $section);
        }
    }
}
