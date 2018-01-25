<?php

namespace App\Helpers\WebApps\ELearning;

use App\Site;

class ELearningHelper
{
    public static function scaffold($id)
    {
        $site = Site::findOrFail($id);
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $home->sections()->create(['title' => 'showcase']);
        $home->sections()->create(['title' => 'articles']);
        $home->sections()->create(['title' => 'courses']);

        $profile = $site->addPage(['title' => 'Profile', 'homePage' => false, 'slug' => 'profile']);
        $signup = $site->addPage(['title' => 'Register', 'homePage' => false, 'slug' => 'register']);
        $signin = $site->addPage(['title' => 'Login', 'homePage' => false, 'slug' => 'login']);
        $about = $site->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);
        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
        $articles = $site->addPage(['title' => 'Articles', 'homePage' => false, 'slug' => 'articles']);
        $courses = $site->addPage(['title' => 'Courses', 'homePage' => false, 'slug' => 'courses']);
        $course = $site->addPage(['title' => 'Course', 'homePage' => false, 'slug' => 'course']);
        $lesson = $site->addPage(['title' => 'Lesson', 'homePage' => false, 'slug' => 'lesson']);
        $forum = $site->addPage(['title' => 'forum', 'homePage' => false, 'slug' => 'forum']);
    }

    public static function doThis($site, $page, $op, $data, $component)
    {
        if ($op === 'site') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->site($page);
        } elseif ('dashboard' === $op) {
            $eLearning = new ELearningSiteHelper($site->id);

            return $eLearning->dashboard($page, $data, $component);
        } elseif ('api-info' === $op) {
            $eLearning = new ELearningSiteHelper($site->id);

            return $eLearning->apiInfo($data);
        } elseif ('createSection' === $op) {
            return SectionHelper::which($page, 'create', $data);
        } elseif ('getSection' === $op) {
            return SectionHelper::which($page, 'get', $data, $component);
        } elseif ('updateSection' === $op) {
            return SectionHelper::which($page, 'update', $data, $component);
        } elseif ('deleteSection' === $op) {
            return SectionHelper::which($page, 'delete', $data, $component);
        } elseif ('dashboard-load-section' === $op) {
            $eLearning = new ELearningSiteHelper($site->id);

            return $eLearning->loadSection($data, $component);
        } elseif ('dashboard-load-action' === $op) {
            $eLearning = new ELearningSiteHelper($site->id);

            return $eLearning->loadAction($data, $component);
        } elseif ('createContent' === $op) {
            return ContentHelper::which($page, 'create', $data, $component);
        } elseif ('getContent' === $op) {
            return ContentHelper::which($page, 'get', $data, $component);
        } elseif ('updateContent' === $op) {
            return ContentHelper::which($page, 'update', $data, $component);
        } elseif ('deleteContent' === $op) {
            return ContentHelper::which($page, 'delete', $data, $component);
        } elseif ('getPage' === $op) {
            return PageHelper::which($page, 'get');
        } elseif ($op === 'updatePage') {
            return PageHelper::which($page, 'update', $data);
        }
    }
}
