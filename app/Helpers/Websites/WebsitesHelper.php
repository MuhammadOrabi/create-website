<?php

namespace App\Helpers\Websites;

use App\Helpers\Websites\Bizlight\BizlightHelper;

class WebsitesHelper
{
    public static function finder($site, $page, $op, $data = null, $component = null)
    {
        if ($site->theme->name === 'bizlight') {
            return BizlightHelper::doThis($site, $page, $op, $data, $component);
        }
    }
}
