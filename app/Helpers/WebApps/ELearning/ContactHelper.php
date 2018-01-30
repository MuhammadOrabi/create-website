<?php

namespace App\Helpers\WebApps\ELearning;

class ContactHelper
{
    public static function index($page, $op, $data, $section)
    {
        if ($op === 'create') {
            return static::store($page, $data);
        } elseif ($op === 'get') {
            return static::show($section);
        } elseif ($op === 'update') {
            return static::update($section, $data);
        } elseif ($op === 'delete') {
            return static::destroy($section);
        }
    }
    
    public static function store($page, $data)
    {
        $message = $page->sections()->create(['type' => 'message', 'title' => $data['subject']]);
        $message->contents()->create(['type' => 'message', 'content' => $data['message'], 'title' => $data['topic']]);
        $message->extras()->create(['type' => 'name', 'content' => $data['name']]);
        $message->extras()->create(['type' => 'email', 'content' => $data['email']]);
        return $message;
    }

    public static function destroy($section)
    {
        $section->contents()->delete();
        $section->extras()->delete();
        $section->delete();
        return $section;
    }
}
