<?php

namespace App\Helpers\Websites;

use App\Helpers\Websites\Bizlight\BizlightHelper;

class WebsitesHelper
{
    public static function finder($site, $page, $op, $data)
    {
        if ($site->theme->name === 'bizlight') {
            $data = BizlightHelper::doThis($site, $page, $op, $data);
            return $data;
        }
    }
}
