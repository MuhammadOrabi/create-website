<?php

namespace App\Helpers\Websites\Bizlight;

/**
 * Helper Class To Preform all the Home Page related
 * Operations for Bizlight template
 */
class HomePageHelper
{
    /**
     * Find the proper helper Function for the operation
     * @param  App\Page $page           The page that the request belongs to
     * @param  String $op               What Operation is requested
     * @param  Array $data              Request Data
     * @param  App\Section $section     The page Section that the request belongs to
     * @return Array                    Data that the Operation needs
     */
    public static function index($page, $op, $data, $section)
    {
        if ($op === 'get') {
            return $section->load('contents');
        } elseif ($op === 'update') {
            return static::which($section, $data);
        }
    }

    /**
     * Find The Proper Section Function
     * @param  App\Section $section     The page Section that the request belongs to
     * @param  Array $data              Request Data
     * @return Array                    Data that the Operation needs
     */
    public static function which($section, $data)
    {
        if ($section->title === 'show-case') {
            return static::showCase($section, $data);
        } elseif ($section->title === 'accordion') {
            return static::accordion($section, $data);
        } elseif ($section->title === 'horizontal-list') {
            return static::sectionA($section, $data);
        } elseif ($section->title === 'paragraph-image') {
            return static::sectionC($section, $data);
        }
    }

    /**
     * Update ShowCase Section
     * @param  App\Section $section     The page Section that the request belongs to
     * @param  Array $data              Request Data
     * @return Array                    Data that the Operation needs
     */
    public static function showCase($section, $data)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return $section;
        } else {
            $section->contents()->delete();
            foreach ($data as $key => $value) {
                if ($value) {
                    $section->contents()->create(['type' => $key, 'content' => $value]);
                }
            }
            return $section;
        }
    }

    /**
     * Update Section B
     * @param  App\Section $section     The page Section that the request belongs to
     * @param  Array $data              Request Data
     * @return Array                    Data that the Operation needs
     */
    public static function accordion($section, $data)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return $section;
        } elseif (isset($data['img'])) {
            $section->contents()->updateOrCreate(['type' => 'img'], ['content' => $data['img']]);
        } elseif ($data['heading'] && $data['paragraph'] && $data['order']) {
            $section->contents()->updateOrCreate(
                ['type' => 'heading', 'order' => $data['order']],
                ['content' => $data['heading']]
            );
            $section->contents()->updateOrCreate(
                ['type' => 'paragraph', 'order' => $data['order']],
                ['content' => $data['paragraph']]
            );
        }
        return $section;
    }

    /**
     * Update Section C
     * @param  App\Section $section     The page Section that the request belongs to
     * @param  Array $data              Request Data
     * @return Array                    Data that the Operation needs
     */
    public static function sectionC($section, $data)
    {
        $section->contents()->delete();
        $section->contents()->create(['type' => 'img', 'content' => $data['img']]);
        $section->contents()->create(['type' => 'paragraph', 'content' => $data['paragraph']]);
        return $section;
    }

    /**
     * Update Section A
     * @param  App\Section $section     The page Section that the request belongs to
     * @param  Array $data              Request Data
     * @return Array                    Data that the Operation needs
     */
    public static function sectionA($section, $data)
    {
        $section->contents()->delete();
        foreach ($data as $key => $item) {
            $section->contents()->create(['type' => 'img', 'content' => $item['img'], 'order' => ($key + 1)]);
            $section->contents()->create(['type' => 'heading', 'order' => ($key + 1), 'content' => $item['heading']]);
            $section->contents()->create(['type' => 'paragraph', 'order' => ($key + 1), 'content' => $item['paragraph']]);
        }
        return $section;
    }
}
