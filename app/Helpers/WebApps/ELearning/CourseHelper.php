<?php

namespace App\Helpers\WebApps\ELearning;

class CourseHelper
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
        return $section->load('contents.extras', 'extras');
    }

    public static function store($page, $data)
    {
        $section = $page->sections()->create(['title' => $data['title']]);
        $section->extras()->create(['type' => 'paragraph', 'content' => $data['paragraph']]);
        foreach ($data['tags'] as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }
        return $section;
    }

    public static function update($section, $data)
    {
        $section->title = $data['title'];
        $section->save();
        $section->extras()->where('type', 'paragraph')->update(['content' => $data['paragraph']]);
        $section->extras()->where('type', 'tag')->delete();
        foreach ($data['tags'] as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }
        return ['msg' => 'success', 'section' => compact('section')];
    }

    public static function destroy($section)
    {
        $section->contents()->each(function ($content) {
            $content->extras()->delete();
            $content->delete();
        });
        $section->extras()->delete();
        $section->delete();
        return 'success';
    }
}
