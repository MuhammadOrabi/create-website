<?php

namespace App\Helpers\Portfolios\Template1;

class SectionHelper
{
    public static function which($op, $data, $section)
    {
        if ($op === 'get') {
            return static::show($section);
        } elseif ($op === 'update') {
            return static::update($data, $section);
        }
    }

    public static function show($section)
    {
        return $section->load('contents.extras');
    }

    public static function update($data, $section)
    {
        if ($section->title === 'Home') {
            return static::home($data, $section);
        } elseif ($section->title === 'About') {
            return static::about($data, $section);
        } elseif ($section->title === 'Skill') {
            return static::skill($data, $section);
        }
    }

    public static function home($data, $section)
    {
        $section->contents()->updateOrCreate(['type' => 'img'], ['content' => $data['img']]);
        $section->contents()->updateOrCreate(['type' => 'title'], ['content' => $data['title']]);
        $section->contents()->updateOrCreate(['type' => 'paragraph'], ['content' => $data['paragraph']]);
        return $section;
    }

    public static function about($data, $section)
    {
        $section->contents()->updateOrCreate(['type' => 'about'], ['content' => $data['about']]);
        $section->contents()->updateOrCreate(['type' => 'name'], ['content' => $data['name']]);
        $section->contents()->updateOrCreate(['type' => 'father'], ['content' => $data['father']]);
        $section->contents()->updateOrCreate(['type' => 'address'], ['content' => $data['address']]);
        $section->contents()->updateOrCreate(['type' => 'zip'], ['content' => $data['zip']]);
        $section->contents()->updateOrCreate(['type' => 'number1'], ['content' => $data['number1']]);
        $section->contents()->updateOrCreate(['type' => 'number2'], ['content' => $data['number2']]);
        $section->contents()->updateOrCreate(['type' => 'email'], ['content' => $data['email']]);
        $section->contents()->updateOrCreate(['type' => 'website'], ['content' => $data['website']]);
        $section->contents()->updateOrCreate(['type' => 'hireme'], ['content' => $data['hireme']]);
        return $section;
    }

    public static function skill($data, $section)
    {
        $section->contents()->delete();
        foreach ($data['skills'] as $skill) {
            $section->contents()->updateOrCreate(['type' => $skill['skill']], ['content' => $skill['value']]);
        }
        return $section;
    }
}
