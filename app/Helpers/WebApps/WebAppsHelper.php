<?php

namespace App\Helpers\WebApps;

use App\Helpers\WebApps\ELearning\ELearningHelper;

class WebAppsHelper
{
    public static function finder($site, $page, $op, $data = null, $component = null)
    {
        if ($site->theme->name === 'elearning') {
            return ELearningHelper::doThis($site, $page, $op, $data, $component);
        }
    }
}
