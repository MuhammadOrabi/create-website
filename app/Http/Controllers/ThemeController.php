<?php

namespace App\Http\Controllers;

use App\Tag;

class ThemeController extends Controller
{
    public function index()
    {
        $tags = Tag::where('type', 'category')->with('themes.imgs')->get();
        return response()->json($tags);
    }

    public function create()
    {
        $tags = Tag::with('themes.imgs')->get();
        if ($tags->isNotEmpty()) {
            return response()->json($tags);
        }
        $tag_website = Tag::create(['tag' => 'website', 'img' => '/img/websites/type-website.svg', 'type' => 'category']);
        $tag_portfolio = Tag::create(['tag' => 'portfolio', 'img' => '/img/portfolios/type-portfolio.svg', 'type' => 'category']);
        $tag_webApp = Tag::create(['tag' => 'web application', 'img' => '/img/web-apps/type-webapp.svg', 'type' => 'category']);
        $tag_blog = Tag::create(['tag' => 'blog', 'img' => '/img/blogs/type-blog.svg', 'type' => 'category']);

        $bizlight = $tag_website->themes()->create(
            ['name' => 'bizlight', 'location' => 'templates.websites.bizlight', 'type' => 'agency']
        );
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/1.png']);
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/2.png']);
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/3.png']);
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/4.png']);
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/5.png']);
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/6.png']);
        $bizlight->imgs()->create(['url' => '/img/websites/Bizlight/7.png']);

        
        $elearning = $tag_webApp->themes()->create(
            ['name' => 'elearning', 'location' => 'templates.web-apps.elearning', 'type' => 'eLearning']
        );
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/1.png']);
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/1.png']);
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/2.png']);
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/3.png']);
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/4.png']);
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/5.png']);
        $elearning->imgs()->create(['url' => '/img/web-apps/elearning/6.png']);

        $portfolio_theme1 = $tag_portfolio->themes()->create(
            ['name' => 'template1', 'location' => 'templates.portfolios.template1', 'type' => 'portfolio']
        );
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/1.png']);
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/2.png']);
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/3.png']);
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/4.png']);
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/5.png']);
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/6.png']);
        $portfolio_theme1->imgs()->create(['url' => '/img/portfolios/template1/7.png']);
        return redirect('/');
    }
}
