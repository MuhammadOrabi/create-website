<?php

namespace App\Helpers\WebApps;

use App\Helpers\WebApps\ELearning\ELearningHelper;

class WebAppsHelper
{
    public static function finder($site, $page, $op, $data)
    {
        if ($site->theme->name === 'elearning') {
            $data = ELearningHelper::doThis($site, $page, $op, $data);
            return $data;
        }
    }
}
