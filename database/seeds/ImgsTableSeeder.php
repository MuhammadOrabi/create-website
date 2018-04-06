<?php

use Illuminate\Database\Seeder;
use App\Theme;

class ImgsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bizlight = Theme::where('location', 'templates.websites.bizlight')->firstOrFail();
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/1.png']);

        $elearning = Theme::where('location', 'templates.web-apps.elearning')->firstOrFail();
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/1.png']);

        $portfolio_theme1 = Theme::where('location', 'templates.portfolios.template1')->firstOrFail();
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/1.png']);

        $blog_template1 = Theme::where('location', 'templates.blogs.template1')->firstOrFail();
        $blog_template1->imgs()->create(['url' => '/img/portfolios/template1/1.png']);
    }
}
