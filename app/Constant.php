<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    protected $guarded = [];
    public function site() {
    	return $this->belongsTo('App\Site');
    }
    public function contents() {
    	return $this->hasMany('App\Content');
    }
}
