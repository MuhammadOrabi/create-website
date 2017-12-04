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
}
