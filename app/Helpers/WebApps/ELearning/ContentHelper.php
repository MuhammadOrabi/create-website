<?php

namespace App\Helpers\WebApps\ELearning;

class ContentHelper
{
    public static function which($page, $op, $data, $component = null)
    {
        if ($page->slug === 'courses') {
            return LessonHelper::index($op, $data, $component);
        }
    }
}
