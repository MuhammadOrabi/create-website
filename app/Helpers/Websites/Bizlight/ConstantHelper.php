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
        if ($data['twitter']) {
            $constant->contants()->updateOrCreate(['type' => 'twitterLink'], ['content' => $data['twitter']]);
        }
        if ($data['twitter']) {
            $constant->contants()->updateOrCreate(['type' => 'twitterLink'], ['content' => $data['twitter']]);
        }
        if ($data['facebook']) {
            $constant->contants()->updateOrCreate(['type' => 'facebookLink'], ['content' => $data['facebook']]);
        }
        if ($data['google']) {
            $constant->contants()->updateOrCreate(['type' => 'googleLink'], ['content' => $data['google']]);
        }
        if ($data['linkedin']) {
            $constant->contants()->updateOrCreate(['type' => 'linkedinLink'], ['content' => $data['linkedin']]);
        }
    }

    public static function get($constant)
    {
        return $constant->load('contents');
    }
}
