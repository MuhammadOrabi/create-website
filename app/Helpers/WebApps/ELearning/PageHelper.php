<?php

namespace App\Helpers\WebApps\ELearning;

/**
*
*/
class PageHelper
{
    public static function which($page, $op)
    {
        if ($op === 'get') {
            return static::get($page);
        }
    }

    public static function get($page)
    {
        return $page->load('sections.contents', 'sections.extras');
    }
}
