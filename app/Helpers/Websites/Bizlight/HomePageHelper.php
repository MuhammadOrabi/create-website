<?php

namespace App\Helpers\Websites\Bizlight;

class HomePageHelper
{
    public static function index($page, $op, $data, $section)
    {
        if ($op === 'get') {
            return $section->contents->toArray();
        } elseif ($op === 'update') {
            return static::which($section, $data);
        }
    }
    public static function which($section, $data)
    {
        if ($section->title === 'showCase') {
            return static::showCase($section, $data);
        } elseif ($section->title === 'section_b') {
            return static::sectionB($section, $data);
        } elseif ($section->title === 'section_a') {
            return static::sectionA($section, $data);
        } elseif ($section->title === 'section_c') {
            return static::sectionC($section, $data);
        }
    }

    public static function showCase($section, $data)
    {
        $section->contents()->delete();
        $section->contents()->create(['type' => 'heading', 'content' => $data['heading']]);
        $section->contents()->create(['type' => 'paragraph', 'content' => $data['paragraph']]);
        return $section;
    }

    public static function sectionB($section, $data)
    {
        $section->contents()->delete();
        $section->contents()->create(['type' => 'img', 'content' => $data['img']]);
        foreach ($data['data'] as $key => $item) {
            $section->contents()->create(
                ['type' => 'heading', 'order' => ($key + 1), 'content' => $item['heading']]
            );
            $section->contents()->create(
                ['type' => 'paragraph', 'order' => ($key + 1), 'content' => $item['paragraph']]
            );
        }
        return $section;
    }

    public static function sectionC($section, $data)
    {
        $section->contents()->delete();
        $section->contents()->create(['type' => 'img', 'content' => $data['img']]);
        $section->contents()->create(['type' => 'paragraph', 'content' => $data['paragraph']]);
        return $section;
    }
    public static function sectionA($section, $data)
    {
        $section->contents()->delete();
        foreach ($data as $key => $item) {
            $section->contents()->create(['type' => 'img', 'content' => $item['img'], 'order' => ($key + 1)]);
            $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $item['heading']]);
            $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $item['paragraph']]);
        }
        return $section;
    }
}
