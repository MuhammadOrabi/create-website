<?php

namespace App\Helpers\Websites\Bizlight;

class PageHelper
{
    public static function which($op, $page, $data = null)
    {
        if ($op === 'get') {
            return static::get($page);
        } elseif ($op === 'update') {
            if ($page->slug === 'about') {
                return static::about($page, $data);
            } elseif ($page->slug === 'services') {
                return static::services($page, $data);
            }
        }
    }

    public static function get($page)
    {
        return $page->load('sections.contents');
    }

    public static function about($page, $data)
    {
        $section = $page->sections()->firstOrCreate(['title' => 'about']);
        return $section->contents()->updateOrCreate(['type' => 'paragraph'], ['content' => $data['paragraph']]);
    }

    public static function services($page, $data)
    {
        $section = $page->sections()->firstOrCreate(['title' => 'services']);
        $section->contents()->updateOrCreate(
            ['type' => 'heading', 'order' => $data['order']],
            ['content' => $data['heading']]
        );
        $section->contents()->updateOrCreate(
            ['type' => 'paragraph', 'order' => $data['order']],
            ['content' => $data['paragraph']]
        );
        return $section;
    }
}
