<?php


namespace App\Helpers\Blogs\Template1;

class SectionHelper
{
    public static function which($page, $op, $data, $section = null)
    {
        if ($op === 'get') {
            return $section->load('contents.extras');
        } elseif ($op === 'create-auth') {
            static::createDashboard($page);
        } elseif ($op === 'delete') {
            static::destroy($section);
        }
    }

    public static function createDashboard($page)
    {
        $page->sections()->create([
            'title' => request('title'),
            'type' => request('type'),
            'order' => request('order'),
            'active' => request('active'),
        ]);
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
}
