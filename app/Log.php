<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->morphedByMany('App\User', 'loggable');
    }

    public function sites()
    {
        return $this->morphedByMany('App\Site', 'loggable');
    }

    public function themes()
    {
        return $this->morphedByMany('App\Theme', 'loggable');
    }

    public function pages()
    {
        return $this->morphedByMany('App\Page', 'loggable');
    }

    public function sections()
    {
        return $this->morphedByMany('App\Section', 'loggable');
    }

    public function contents()
    {
        return $this->morphedByMany('App\Content', 'loggable');
    }

    public function imgs()
    {
        return $this->morphedByMany('App\Img', 'loggable');
    }

    public function extras()
    {
        return $this->morphedByMany('App\Extra', 'loggable');
    }
}
