<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ['tag' => 'website', 'img' => '/img/websites/type-website.svg', 'type' => 'category'],
            ['tag' => 'portfolio', 'img' => '/img/portfolios/type-portfolio.svg', 'type' => 'category'],
            ['tag' => 'web application', 'img' => '/img/web-apps/type-webapp.svg', 'type' => 'category'],
            ['tag' => 'blog', 'img' => '/img/blogs/type-blog.svg', 'type' => 'category']
        ]);
    }
}
