<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
	public function index() {
	    $tags = Tag::with('themes.imgs')->get();
	    return response()->json($tags);
	}
	
    public function create() {
    	$tags = Tag::with('themes.imgs')->get();
    	if ($tags->isNotEmpty()) {
    		return response()->json($tags);
    	}
    	$tag_website = Tag::create(['tag' => 'website', 'img' => '/img/type-website.svg']);
    	$tag_portfolio = Tag::create(['tag' => 'portfolio', 'img' => '/img/type-portfolio.svg']);
    	$tag_webApp = Tag::create(['tag' => 'webApp', 'img' => '/img/type-website.svg']);
    	$tag_blog = Tag::create(['tag' => 'blog', 'img' => '/img/type-blog.svg']);

        $bizlight = $tag_website->themes()->create(['name' => 'Bizlight', 'location' => 'bizlight', 'type' => 'agency']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/1.png']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/2.png']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/3.png']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/4.png']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/5.png']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/6.png']);
        $bizlight->imgs()->create(['url' => '/img/Bizlight/7.png']);

        $academy = $tag_webApp->themes()->create(['name' => 'Academy', 'location' => 'sys.theme1', 'type' => 'eLearning']);
        $academy->imgs()->create(['url' => '/img/academy/1.png']);
        $academy->imgs()->create(['url' => '/img/academy/2.png']);
        $academy->imgs()->create(['url' => '/img/academy/3.png']);
        $academy->imgs()->create(['url' => '/img/academy/4.png']);
        $academy->imgs()->create(['url' => '/img/academy/5.png']);
        $academy->imgs()->create(['url' => '/img/academy/6.png']);

        $portfolio_theme1 = $tag_portfolio->themes()->create(['name' => 'Portfolio', 'location' => 'portfolio.theme1', 'type' => 'portfolio']);
        return redirect('/');
    }
}
