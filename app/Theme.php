<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $guarded = [];

    public function sites()
    {
        return $this->hasMany('App\Site');
    }

    public function imgs()
    {
        return $this->morphMany('App\Img', 'imgable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'logable');
    }
}
