<?php

namespace App\Helpers\WebApps\ELearning;

class SectionHelper
{
    public static function which($page, $op, $data, $component = null)
    {
        if ($page->slug === 'courses') {
            return CourseHelper::index($page, $op, $data, $component);
        }
    }
}
