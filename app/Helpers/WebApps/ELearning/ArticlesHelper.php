<?php

namespace App\Helpers\WebApps\ELearning;

class ArticlesHelper
{
    public static function index($page, $op, $data, $section = null)
    {
        if ($op === 'create') {
            return static::store($page, $data);
        } elseif ($op === 'get') {
            return static::show($section);
        } elseif ($op === 'update') {
            return static::update($section, $data);
        } elseif ($op === 'delete') {
            return static::destroy($section);
        }
    }

    public static function show($section)
    {
        return $section->load('contents', 'extras');
    }

    public static function store($page, $data)
    {
        $section = $page->sections()->create(['title' => $data['title']]);
        $section->contents()->create(['type' => 'paragraph', 'content' => $data['paragraph']]);
        if ($data['img']) {
            $section->extras()->create(['type' => 'img', 'content' => $data['img']]);
        }
        foreach ($data['tags'] as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }
        return $section;
    }
}
