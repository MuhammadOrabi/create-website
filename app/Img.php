<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    protected $guarded = [];
    public function site() {
    	return $this->belongsTo('App\Site');
    }
    public function theme() {
    	return $this->belongsTo('App\Theme');
    }
    public function tags() {
        return $this->belongsToMany('App\Tag', 'tag_img');
    }
}
