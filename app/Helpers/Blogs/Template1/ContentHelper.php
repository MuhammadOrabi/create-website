<?php


namespace App\Helpers\Blogs\Template1;

class ContentHelper
{
    public static function which($page, $op, $data, $component = null)
    {
        if ($page->slug === 'page') {
            return ItemsHelper::index($op, $page, $data, $component);
        }
    }
}
