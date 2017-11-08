<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
   	protected $guarded = [];
    public function sites() {
        return $this->hasMany('App\Site');
    }
    public function imgs() {
        return $this->hasMany('App\Img');
    }
    public function tags() {
        return $this->belongsToMany('App\Tag', 'tag_theme');
    }
}
