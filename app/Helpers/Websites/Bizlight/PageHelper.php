<?php

namespace App\Helpers\Websites\Bizlight;

class PageHelper
{
    public static function which($op, $page)
    {
        if ($op === 'get') {
            return static::get($page);
        }
    }

    public static function get($page)
    {
        return $page->load('sections');
    }
}
