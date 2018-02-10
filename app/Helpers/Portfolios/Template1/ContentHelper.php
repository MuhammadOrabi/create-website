<?php

namespace App\Helpers\Portfolios\Template1;

class ContentHelper
{
    public static function which($op, $content)
    {
        if ($op === 'get') {
            return $content->load('extras');
        } elseif ($op === 'delete') {
            $content->extras()->delete();
            return $content->delete();
        }
    }
}
