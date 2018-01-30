<?php

namespace App\Helpers\Websites\Bizlight;

/**
 * Helper Class To Preform all the general Section related
 * Operations for Bizlight template
 */
class SectionHelper
{
    /**
     *  Find the proper helper Page class for the operation
     * @param  App\Page $page           The page that the request belongs to
     * @param  String $op               What Operation is requested
     * @param  Array $data              Request Data
     * @param  App\Section $section     The page Section that the request belongs to
     * @return Array                    Data that the Operation needs
     */
    public static function which($page, $op, $data, $section = null)
    {
        if ($page->slug === 'about') {
            return AboutHelper::index($page, $op, $data, $section);
        } elseif ($page->slug === 'services') {
            return ServicesHelper::index($page, $op, $data, $section);
        } elseif ($page->homePage) {
            return HomePageHelper::index($page, $op, $data, $section);
        } elseif ($page->slug === 'contact') {
            return ContactHelper::index($page, $op, $data, $section);
        }
    }
}
