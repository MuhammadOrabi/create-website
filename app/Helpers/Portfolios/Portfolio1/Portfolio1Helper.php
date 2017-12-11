<?php

namespace App\Portfolios\Portfolio1;

use App\Site;

class Portfolio1Helper
{
    public static function scaffold($id)
    {
        $site = Site::findOrFail($id);
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
    }
}
