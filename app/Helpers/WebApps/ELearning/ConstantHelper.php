<?php

namespace App\Helpers\WebApps\ELearning;

class ConstantHelper
{
    public static function which($op, $data, $constant)
    {
        if ($op === 'update') {
            return static::update($data, $constant);
        } elseif ($op === 'get') {
            return static::show($constant);
        }
    }
    public static function update($data, $constant)
    {
        $constant->contents()->update(['active' => false]);
        foreach ($data['footer'] as $type) {
            if ($type === 'paragraph') {
                $constant->contents()->updateOrCreate(['type' => $type], ['content' => $data['paragraph'], 'active' => true]);
            } elseif ($type === 'logo') {
                $constant->contents()->updateOrCreate(['type' => 'logo'], ['active' => true]);
            } elseif ($type === 'links') {
                $constant->contents()->updateOrCreate(['type' => 'links'], ['active' => true]);
            }
        }
        $content = $constant->contents()->where('type', 'links')->first();
        if ($content) {
            foreach ($data['links'] as $key => $link) {
                if ($link) {
                    $content->extras()->updateOrCreate(['type' => $key], ['content' => $link]);
                }
            }
        }
        
        return $constant;
    }

    public static function show($constant)
    {
        return $constant->load('contents.extras', 'site.extras');
    }
}
