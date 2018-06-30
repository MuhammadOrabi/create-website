<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    protected $guarded = [];

    public function imgable()
    {
        return $this->morphTo();
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function logs()
    {
        return $this->morphToMany('App\Log', 'loggable');
    }

    // Helper Function
    public function addLables($lables)
    {
        foreach ($lables as $label) {
            $tag = Tag::firstOrCreate(['tag' => $label]);
            $this->tags()->attach($tag->id);
        }
    }
}
