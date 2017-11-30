<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function imgs()
    {
        return $this->morphedByMany('App\Img', 'taggable');
    }

    public function themes()
    {
        return $this->morphedByMany('App\Theme', 'taggable');
    }
}
