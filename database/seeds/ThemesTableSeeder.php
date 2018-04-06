<?php

use Illuminate\Database\Seeder;
use App\Tag;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag_website = Tag::where('tag', 'website')->firstOrFail();
        $tag_portfolio = Tag::where('tag', 'portfolio')->firstOrFail();
        $tag_webApp = Tag::where('tag', 'web application')->firstOrFail();
        $tag_blog = Tag::where('tag', 'blog')->firstOrFail();

        $bizlight = $tag_website->themes()->create(
            ['name' => 'bizlight', 'location' => 'templates.websites.bizlight', 'type' => 'agency']
        );

        $elearning = $tag_webApp->themes()->create(
            ['name' => 'elearning', 'location' => 'templates.web-apps.elearning', 'type' => 'eLearning']
        );

        $portfolio_theme1 = $tag_portfolio->themes()->create(
            ['name' => 'template1', 'location' => 'templates.portfolios.template1', 'type' => 'portfolio']
        );

        $blog_template1 = $tag_blog->themes()->create(
            ['name' => 'template1', 'location' => 'templates.blogs.template1', 'type' => 'blog']
        );
    }
}
