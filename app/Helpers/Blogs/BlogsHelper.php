<?php

namespace App\Helpers\Blogs;

use App\Helpers\Blogs\Template1\Template1Helper;

class BlogsHelper
{
    public static function finder($site, $page, $op, $data = null, $component = null)
    {
        if ($site->theme->name === 'template1') {
            return Template1Helper::doThis($site, $page, $op, $data, $component);
        }
    }
}
