<?php

namespace App\Helpers\Websites\Bizlight;

class SectionHelper
{
    public static function which($page, $op, $data)
    {
        if ($op === 'get') {
            return $data->contents->toArray();
        }
    }
}
