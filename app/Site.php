<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded = [];

    // Site Reltionships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function imgs()
    {
        return $this->morphMany('App\Img', 'imgable');
    }

    public function extras()
    {
        return $this->morphMany('App\Extra', 'extraable');
    }

    public function constants()
    {
        return $this->hasMany('App\Constant');
    }

    public function logs()
    {
        return $this->morphToMany('App\Log', 'loggable');
    }

    // Helper methods
    public function addPage($page)
    {
        return $this->pages()->create($page);
    }

    public function addImage($url)
    {
        return $this->imgs()->create(compact('url'));
    }

    // Initialize themes
    public function bizlight_init()
    {
        $home = $this->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $showCase = $home->sections()->create(['title' => 'showCase', 'order' => 1]);
        $showCase->contents()->create(['type' => 'heading']);
        $showCase->contents()->create(['type' => 'paragraph']);

        $section_b = $home->sections()->create(['title' => 'section_b', 'order' => 2]);
        $section_b->contents()->create(['type' => 'heading', 'order' => 1]);
        $section_b->contents()->create(['type' => 'paragraph', 'order' => 1]);
        $section_b->contents()->create(['type' => 'heading', 'order' => 2]);
        $section_b->contents()->create(['type' => 'paragraph', 'order' => 2]);
        $section_b->contents()->create(['type' => 'heading', 'order' => 3]);
        $section_b->contents()->create(['type' => 'paragraph', 'order' => 3]);
        $section_b->contents()->create(['type' => 'img']);

        $section_a = $home->sections()->create(['title' => 'section_a', 'order' => 3]);
        $section_a->contents()->create(['type' => 'heading', 'order' => 1]);
        $section_a->contents()->create(['type' => 'paragraph', 'order' => 1]);
        $section_a->contents()->create(['type' => 'img', 'order' => 1]);
        $section_a->contents()->create(['type' => 'heading', 'order' => 2]);
        $section_a->contents()->create(['type' => 'paragraph', 'order' => 2]);
        $section_a->contents()->create(['type' => 'img', 'order' => 2]);
        $section_a->contents()->create(['type' => 'heading', 'order' => 3]);
        $section_a->contents()->create(['type' => 'paragraph', 'order' => 3]);
        $section_a->contents()->create(['type' => 'img', 'order' => 3]);

        $section_c = $home->sections()->create(['title' => 'section_c', 'order' => 4]);
        $section_c->contents()->create(['type' => 'paragraph']);
        $section_c->contents()->create(['type' => 'img']);

        $about = $this->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $aboutSection = $about->sections()->create(['title' => 'aboutSection', 'order' => 1]);
        $aboutSection->contents()->create(['type' => 'paragraph']);

        $services = $this->addPage(['title' => 'Services', 'homePage' => false, 'slug' => 'services']);
        $servicesSection = $services->sections()->create(['title' => 'servicesSection', 'order' => 1]);
        $servicesSection->contents()->create(['type' => 'heading', 'order' => 1]);
        $servicesSection->contents()->create(['type' => 'paragraph', 'order' => 1]);
        $servicesSection->contents()->create(['type' => 'heading', 'order' => 2]);
        $servicesSection->contents()->create(['type' => 'paragraph', 'order' => 2]);
        $servicesSection->contents()->create(['type' => 'heading', 'order' => 3]);
        $servicesSection->contents()->create(['type' => 'paragraph', 'order' => 3]);

        $top_nav = $this->constants()->create(['type' => 'top-nav']);
        $top_nav->contents()->create(['type' => 'twitterLink']);
        $top_nav->contents()->create(['type' => 'facebookLink']);
        $top_nav->contents()->create(['type' => 'googleLink']);
        $top_nav->contents()->create(['type' => 'linkedinLink']);

        $contact = $this->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
    }

    public function sys_theme1_init()
    {
        $home = $this->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $profile = $this->addPage(['title' => 'Profile', 'homePage' => false, 'slug' => 'profile']);
        $signup = $this->addPage(['title' => 'Sign Up', 'homePage' => false, 'slug' => 'signup']);
        $signin = $this->addPage(['title' => 'Sign In', 'homePage' => false, 'slug' => 'signin']);
        $about = $this->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $contact = $this->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
        $news = $this->addPage(['title' => 'News', 'homePage' => false, 'slug' => 'news']);
        $courses = $this->addPage(['title' => 'Courses', 'homePage' => false, 'slug' => 'courses']);
        $course = $this->addPage(['title' => 'Course', 'homePage' => false, 'slug' => 'course']);
        $lessons = $this->addPage(['title' => 'Lessons', 'homePage' => false, 'slug' => 'lessons']);
        $lesson = $this->addPage(['title' => 'Lesson', 'homePage' => false, 'slug' => 'lesson']);
        $forum = $this->addPage(['title' => 'forum', 'homePage' => false, 'slug' => 'forum']);
    }

    public function portfolio_theme1_init()
    {
        $home = $this->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
    }
}
