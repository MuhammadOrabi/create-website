<?php


namespace App\Helpers\Blogs\Template1;

use App\Content;

class SectionHelper
{
    public static function which($page, $op, $data, $section = null)
    {
        if ($op === 'get') {
            return $section->load('contents.extras');
        } elseif ($op === 'create-auth') {
            static::createDashboard($page, $data);
        } elseif ($op === 'delete') {
            static::destroy($section);
        } elseif ($op === 'create-comment') {
            self::createComment($page, $data);
        }
    }

    public static function createDashboard($page, $data)
    {
        $section = $page->sections()->create([
            'title' => $data['title'],
            'type' => 'page',
            'order' => $data['order'],
            'active' => $data['active'],
        ]);
        foreach ($data['tags'] as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }

        return response('success', 200);
    }

    public static function destroy($section)
    {
        $section->contents()->each(function ($content) {
            $content->extras()->delete();
            $content->delete();
        });
        $section->extras()->delete();
        $section->delete();
        return response('success', 200);
    }

    public static function createComment($page)
    {
        $content = Content::where('id', request()->component)->firstOrFail();
        abort_if($content->contentable->page->id !== $page->id, 500);
        $comment = $content->extras()->create([
            'type' => 'comment',
            'title' => request('first_name') . ' ' . request('last_name'),
            'content' => request('message')
        ]);
    }
}
