<?php

namespace App\Helpers\WebApps\ELearning;

/**
 * Helper Class To Preform all the general Page related Operation
 */
class PageHelper
{
    /**
      *  Find the proper helper Page class for the operation
      * @param  App\Page $page           The page that the request belongs to
      * @param  String $op               What Operation is requested
      * @param  Array $data              Request Data
      * @return Array                    Data that the Operation needs
      */
    public static function which($page, $op, $data = null)
    {
        if ($op === 'get-auth') {
            return static::getDashboard($page);
        } elseif ($op === 'update') {
            return static::update($page, $data);
        } elseif ($op === 'get') {
            return static::getSite($page);
        }
    }

    /**
     * Load Page Data
     * @param  App\Page $page           The page that the request belongs to
     * @return Array                    Data that the Operation needs
     */
    public static function getDashboard($page)
    {
        return $page->load(['sections' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'sections.extras', 'sections.contents']);
    }

    public static function getSite($page)
    {
        if ($page->slug === 'courses') {
            return $page->load(['sections' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }, 'sections.extras']);
        } elseif ($page->slug === 'articles') {
            return $page->load(['sections' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }, 'sections.extras', 'sections.contents']);
        } elseif ($page->homePage) {
            $site = $page->site;
            $courses = $site->pages()->where('slug', 'courses')->with(['sections' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }, 'sections.extras'])->first();
            $articles = $site->pages()->where('slug', 'articles')->with(['sections' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }, 'sections.extras', 'sections.contents'])->first();
            return ['page' => $page->load('sections.contents'), 'courses' => $courses, 'articles' => $articles];
        }
    }

    /**
      *  Find the proper helper Page class for Update
      * @param  App\Page $page           The page that the request belongs to
      * @param  Array $data              Request Data
      * @return Array                    Data that the Operation needs
      */
    public static function update($page, $data)
    {
        if ($page->homePage) {
            return HomePageHelper::update($page, $data);
        }
    }
}
