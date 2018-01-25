<?php

namespace App\Helpers\WebApps\ELearning;

/**
 * Helper Class To Preform all the Home Page related Operation
 */
class HomePageHelper
{
    /**
     * Update
     * @param  App\Page $page           The page that the request belongs to
     * @param  Array $data              Request Data
     * @return Array                    Data that the Operation needs
     */
    public static function update($page, $data)
    {
        $page->sections()->update(['active' => 0]);
        foreach ($data['sections'] as $section) {
            $page->sections()->where('title', $section)->update(['active' => 1]);
        }
        $page->sections()->where('title', 'showcase')->first()
             ->contents()->updateOrCreate(['type' => 'img'], ['content' => $data['img']]);

        return $page;
    }
}
