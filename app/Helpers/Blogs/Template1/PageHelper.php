<?php

namespace App\Helpers\Blogs\Template1;

use Illuminate\Http\Request;

class PageHelper
{
    public static function which($page, $op, $data)
    {
        if ($op === 'get-auth') {
            return static::getDashboard($page);
        } elseif ($op === 'update') {
            return static::update($page, $data);
        } elseif ($op === 'get') {
            return static::getSite($page);
        }
    }

    public static function getDashboard($page)
    {
        return $page->load(['sections' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'sections.extras', 'sections.contents']);
    }
}
