<?php

namespace App\Helpers\Websites\Bizlight;

class AboutHelper
{
    public static function index($page, $op, $data = null, $section = null)
    {
        if ($op === 'get') {
            return $section->contents->toArray();
        } elseif ($op === 'update') {
            return static::update($section, $data);
        }
    }

    public static function update($section, $data)
    {
        $section->contents()->delete();
        $section->contents()->create(['type' => 'paragraph', 'content' => $data[0]['paragraph']]);
    }
}
