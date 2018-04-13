<?php

namespace App\Helpers\WebApps\ELearning;

class ExtraHelper
{
    public static function which($page, $op, $data, $component = null)
    {
        if ($page->slug === 'courses') {
            switch ($op) {
                case 'create':
                    return self::createFile($component, $data);
                    break;
                case 'get':
                    return self::showFile($component);
                    break;
                case 'update':
                    return self::updateFile($component, $data);
                    break;
                case 'delete':
                    return self::destroyFile($component);
                    break;
            }
        }
    }

    public static function createFile($section, $data)
    {
        return $section->extras()->create([
            'type' => 'file',
            'title' => $data['title'],
            'content' => $data['file']
        ]);
    }

    public static function showFile($extra)
    {
        return $extra->load('extraable.extras');
    }

    public static function destroyFile($extra)
    {
        return $extra->delete();
    }

    public static function updateFile($extra)
    {
        return $extra->update([
            'title' => request('title'),
            'content' => request('file')
        ]);
    }
}
