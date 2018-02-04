<?php

namespace App\Helpers\Portfolios;

use App\Helpers\Portfolios\Template1\Template1Helper;

class PortfoliosHelper
{
    public static function finder($site, $page, $op, $data = null, $component = null)
    {
        if ($site->theme->name === 'template1') {
            return Template1Helper::doThis($site, $page, $op, $data, $component);
        }
    }
}
