<?php

namespace App\Helpers\Websites\Bizlight;

/**
 * Helper Class To Preform all the Services Page related
 * Operations for Bizlight template
 */
class ServicesHelper
{
    /**
     * Find the proper helper Function for the operation
     * @param  App\Page $page           The page that the request belongs to
     * @param  String $op               What Operation is requested
     * @param  Array $data              Request Data
     * @param  App\Section $section     The page Section that the request belongs to
     * @return Array                    Data that the Operation needs
     */
    public static function index($page, $op, $data, $section)
    {
        if ($op === 'get') {
            return $section->contents->toArray();
        }
    }


}
