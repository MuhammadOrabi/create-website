<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    public function imgs() {
        return $this->belongsToMany('App\Img', 'tag_img');
    }
    public function themes() {
        return $this->belongsToMany('App\Theme', 'tag_theme');
    }
}
