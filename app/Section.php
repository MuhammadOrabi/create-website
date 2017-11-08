<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];
    public function page() {
    	return $this->belongsTo('App\Page');
    }
    public function contents() {
    	return $this->hasMany('App\Content');
    }
    public function extras() {
        return $this->hasMany('App\Extra');
    }
}
