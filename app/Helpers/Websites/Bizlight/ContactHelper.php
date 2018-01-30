<?php

namespace App\Helpers\Websites\Bizlight;

class ContactHelper
{
    public static function index($page, $op, $data, $section = null)
    {
        if ($op === 'create') {
            return static::store($page, $data);
        } elseif ($op === 'delete') {
            return static::destroy($section);
        }
    }

    public static function store($page, $data)
    {
        $msg = $page->sections()->create(['title' => 'msg']);
        $msg->contents()->create(['type' => 'name', 'content' => $data['name']]);
        $msg->contents()->create(['type' => 'email', 'content' => $data['email']]);
        $msg->contents()->create(['type' => 'message', 'content' => $data['message']]);
        return $msg;
    }

    public static function destroy($section)
    {
        $section->contents()->delete();
        $section->extras()->delete();
        $section->delete();
        return $section;
    }
}
