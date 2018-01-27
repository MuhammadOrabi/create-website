<?php

namespace App\Helpers\WebApps\ELearning;

class LessonHelper
{
    public static function index($op, $data, $component)
    {
        if ($op === 'create') {
            return static::store($component, $data);
        } elseif ($op === 'get') {
            return static::show($component);
        } elseif ($op === 'update') {
            return static::update($component, $data);
        } elseif ($op === 'delete') {
            return static::destroy($component);
        } elseif ($op === 'get-site') {
            return static::show($component);
        }
    }

    public static function store($section, $data)
    {
        $content = $section->contents()->create(
            ['type' => 'lesson', 'title' => $data['title'], 'content' => $data['paragraph']]
        );
        $content->extras()->create(['type' => 'video', 'content' => $data['video']]);
        return $content;
    }

    public static function show($content)
    {
        return $content->load('extras', 'contentable.contents');
    }

    public static function update($content, $data)
    {
        $content->update(
            ['title' => $data['title'], 'content' => $data['paragraph']]
        );
        $content->extras()->where('type', 'video')->update(['content' => $data['video']]);
        return $content;
    }

    public static function destroy($content)
    {
        $content->extras()->delete();
        $content->delete();
        return $content;
    }
}
