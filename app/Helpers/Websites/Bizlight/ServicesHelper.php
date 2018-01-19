<?php

namespace App\Helpers\Websites\Bizlight;

class ServicesHelper
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
        foreach ($data as $key => $item) {
            $section->contents()
                        ->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $item['heading']]);
            $section->contents()
                        ->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $item['paragraph']]);
        }
        return $section;
    }
}
