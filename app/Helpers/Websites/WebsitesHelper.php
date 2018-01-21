<?php

namespace App\Helpers\Websites;

use App\Helpers\Websites\Bizlight\BizlightHelper;

/**
 * Helper Class to do all the general
 * jobs on a Website Templates Category
 */
class WebsitesHelper
{
    /**
     * Find which template the request belongs to
     * @param  App\Site $site       The site that the request belongs to
     * @param  App\Page $page       The page that the request belongs to
     * @param  String $op           What Operation is requested
     * @param  Array $data          Request Data
     * @param  [type] $component    Any Other Models that the request might need
     * @return Array                Data that the Operation needs
     */
    public static function finder($site, $page, $op, $data = null, $component = null)
    {
        if ($site->theme->name === 'bizlight') {
            return BizlightHelper::doThis($site, $page, $op, $data, $component);
        }
    }
}
