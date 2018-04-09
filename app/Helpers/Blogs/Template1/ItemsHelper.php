<?php


namespace App\Helpers\Blogs\Template1;

class ItemsHelper
{
    public static function index($op, $page, $data, $component)
    {
        if ($op === 'create') {
            return self::create($data, $component);
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

    public static function create($data, $section)
    {
        $content = $section->contents()->create(
            ['type' => 'item', 'title' => $data['title'], 'content' => $data['paragraph']]
        );
        if ($data['video']) {
            $content->extras()->create(['type' => 'video', 'content' => $data['video']]);
        }
        if ($data['img']) {
            $content->extras()->create(['type' => 'img', 'content' => $data['img']]);
        }
        return response()->json($content);
    }

    public static function show($content)
    {
        $content->load('extras', 'contentable.contents');
        return response()->json($content);
    }

    public static function update($content, $data)
    {
        $content->update(
            ['title' => $data['title'], 'content' => $data['paragraph']]
        );
        if ($data['video']) {
            $content->extras()->updateOrCreate(['type' => 'video'], ['content' => $data['video']]);
        } else {
            $content->extras()->where('type', 'video')->delete();
        }
        if ($data['img']) {
            $content->extras()->updateOrCreate(['type' => 'img'], ['content' => $data['img']]);
        } else {
            $content->extras()->where('type', 'img')->delete();
        }

        return response()->json($content);
    }

    public static function destroy($content)
    {
        $content->extras()->delete();
        $content->delete();
        return response()->json($content);
    }
}
