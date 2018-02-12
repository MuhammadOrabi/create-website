<?php

namespace App\Helpers\Portfolios\Template1;

class SectionHelper
{
    public static function which($op, $data, $section, $page = null)
    {
        if ($op === 'get') {
            return static::show($section);
        } elseif ($op === 'update') {
            return static::update($data, $section);
        } elseif ($op === 'create-site') {
            return static::createSite($data, $page);
        }
    }

    public static function show($section)
    {
        return $section->load('contents.extras');
    }

    public static function update($data, $section)
    {
        if ($section->title === 'Home') {
            return static::home($data, $section);
        } elseif ($section->title === 'About') {
            return static::about($data, $section);
        } elseif ($section->title === 'Skill') {
            return static::skill($data, $section);
        } elseif ($section->title === 'Education') {
            return static::education($data, $section);
        } elseif ($section->title === 'Experience') {
            return static::experience($data, $section);
        } elseif ($section->title === 'Left Show Case') {
            return static::leftShowCase($data, $section);
        } elseif ($section->title === 'Contact') {
            return static::contact($data, $section);
        }
    }

    public static function home($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $section->active];
        } else {
            $section->contents()->updateOrCreate(['type' => 'img'], ['content' => $data['img']]);
            $section->contents()->updateOrCreate(['type' => 'title'], ['content' => $data['title']]);
            $section->contents()->updateOrCreate(['type' => 'paragraph'], ['content' => $data['paragraph']]);
            return $section;
        }
    }

    public static function about($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $data['status']];
        } else {
            foreach ($data as $key => $value) {
                $section->contents()->updateOrCreate(['type' => $key], ['content' => $value]);
            }
            return $section;
        }
    }

    public static function skill($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $data['status']];
        } else {
            $section->contents()->delete();
            foreach ($data['skills'] as $skill) {
                $section->contents()->updateOrCreate(['type' => $skill['skill']], ['content' => $skill['value']]);
            }
            return $section;
        }
    }

    public static function education($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $data['status']];
        } else {
            $education = $section->contents()->updateOrCreate(['type' => 'education', 'title' => $data['school']], ['content' => $data['field_of_study']]);

            $education->extras()->updateOrCreate(['type' => 'from_year'], ['content' => $data['from_year']]);
            if ($data['grade']) {
                $education->extras()->updateOrCreate(['type' => 'grade'], ['content' => $data['grade']]);
            }
            if ($data['degree']) {
                $education->extras()->updateOrCreate(['type' => 'degree'], ['content' => $data['degree']]);
            }
            if ($data['current']) {
                $education->extras()->where('type', 'to_year')->delete();
            } else {
                $education->extras()->updateOrCreate(['type' => 'to_year'], ['content' => $data['to_year']]);
            }
            return $education;
        }
    }

    public static function experience($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $data['status']];
        } else {
            $experience = $section->contents()->updateOrCreate(['type' => 'experience', 'title' => $data['title']], ['content' => $data['company']]);
            $experience->extras()->updateOrCreate(['type' => 'from_year'], ['content' => $data['from_year']]);
            if ($data['current']) {
                $experience->extras()->where('type', 'to_year')->delete();
            } else {
                $experience->extras()->updateOrCreate(['type' => 'to_year'], ['content' => $data['to_year']]);
            }
            return $experience;
        }
    }

    public static function leftShowCase($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $data['status']];
        } else {
            $section->contents()->delete();
            if ($data['img']) {
                $section->contents()->updateOrCreate(['type' => 'img'], ['content' => $data['img']]);
            }
            if ($data['title']) {
                $section->contents()->updateOrCreate(['type' => 'title'], ['content' => $data['title']]);
            }
            if ($data['subtitle']) {
                $section->contents()->updateOrCreate(['type' => 'subtitle'], ['content' => $data['subtitle']]);
            }
            foreach ($data['links'] as $key => $link) {
                if ($link) {
                    $section->contents()->updateOrCreate(['type' => $key], ['content' => $link]);
                }
            }
            return $section;
        }
    }

    public static function contact($data, $section)
    {
        if (isset($data['status'])) {
            $section->update(['active' => $data['status']]);
            return ['status' => $data['status']];
        }
    }

    public static function createSite($data, $page)
    {
        $messages = $page->sections()->where('title', 'Contact')->first();
        $message = $messages->contents()->create(['type' => 'message', 'title' => $data['subject'], 'content' => $data['message']]);
        $message->extras()->create(['type' => 'info', 'title' => $data['name'], 'content' => $data['email']]);
    }
}
