<?php

namespace App\Helpers\Websites\Bizlight;

class ConstantHelper
{
    public static function which($op, $data, $constant)
    {
        if ($op === 'update') {
            return static::update($data, $constant);
        } elseif ($op === 'get') {
            return static::get($constant);
        }
    }

    public static function update($data, $constant)
    {
        $constant->contents()->updateOrCreate(['type' => 'link', 'title' => 'twitter'], ['content' => $data['twitter']]);
        $constant->contents()->updateOrCreate(['type' => 'link', 'title' => 'facebook-square'], ['content' => $data['facebook']]);
        $constant->contents()->updateOrCreate(['type' => 'link', 'title' => 'google-plus-g'], ['content' => $data['google']]);
        $constant->contents()->updateOrCreate(['type' => 'link', 'title' => 'linkedin-in'], ['content' => $data['linkedin']]);
        $constant->contents()->updateOrCreate(['type' => 'logo'], ['content' => $data['logo']]);
    }

    public static function get($constant)
    {
        return $constant->load('contents');
    }
}
