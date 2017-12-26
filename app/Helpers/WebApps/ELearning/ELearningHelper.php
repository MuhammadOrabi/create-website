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
        $signup = $site->addPage(['title' => 'Register', 'homePage' => false, 'slug' => 'register']);
        $signin = $site->addPage(['title' => 'Login', 'homePage' => false, 'slug' => 'login']);
        $about = $site->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
        $news = $site->addPage(['title' => 'News', 'homePage' => false, 'slug' => 'news']);
        $courses = $site->addPage(['title' => 'Courses', 'homePage' => false, 'slug' => 'courses']);
        $course = $site->addPage(['title' => 'Course', 'homePage' => false, 'slug' => 'course']);
        $lesson = $site->addPage(['title' => 'Lesson', 'homePage' => false, 'slug' => 'lesson']);
        $forum = $site->addPage(['title' => 'forum', 'homePage' => false, 'slug' => 'forum']);
    }

    public static function doThis($site, $page, $op, $data)
    {
        if ($op === 'createOrUpdateContent') {
        } elseif ($op === 'site') {
            $site = new ELearningSiteHelper($site->id);
            return $site->site($page);
        } elseif ($op === 'dashboard') {
            $site = new ELearningSiteHelper($site->id);
            return $site->dashboard($page);
        } elseif ($op === 'api-info') {
            $site = new ELearningSiteHelper($site->id);
            return $site->apiInfo($data);
        }
    }
}
