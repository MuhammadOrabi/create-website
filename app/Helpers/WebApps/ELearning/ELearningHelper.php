<?php

namespace App\Helpers\WebApps\ELearning;

use App\Site;

class ELearningHelper
{
    public static function scaffold($id)
    {
        $site = Site::findOrFail($id);
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $profile = $site->addPage(['title' => 'Profile', 'homePage' => false, 'slug' => 'profile']);
        $signup = $site->addPage(['title' => 'Sign Up', 'homePage' => false, 'slug' => 'signup']);
        $signin = $site->addPage(['title' => 'Sign In', 'homePage' => false, 'slug' => 'signin']);
        $about = $site->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
        $news = $site->addPage(['title' => 'News', 'homePage' => false, 'slug' => 'news']);
        $courses = $site->addPage(['title' => 'Courses', 'homePage' => false, 'slug' => 'courses']);
        $course = $site->addPage(['title' => 'Course', 'homePage' => false, 'slug' => 'course']);
        $lessons = $site->addPage(['title' => 'Lessons', 'homePage' => false, 'slug' => 'lessons']);
        $lesson = $site->addPage(['title' => 'Lesson', 'homePage' => false, 'slug' => 'lesson']);
        $forum = $site->addPage(['title' => 'forum', 'homePage' => false, 'slug' => 'forum']);
    }
}
