<?php

namespace App\Helpers\Websites\Bizlight;

class ContentHelper
{
    public static function whcih($content, $op, $data) 
    {
        if ($op === 'delete-content') {
            return static::destroy($content);
        }
    }

    public static function destroy($content) 
    {
        $section = $content->contentable;
        if ($section->title === 'accordion') {
            $section->contents()->where('order', $content->order)->delete();
        }
    }
}
