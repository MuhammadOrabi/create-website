<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];
    public function site() {
    	return $this->belongsTo('App\Site');
    }
    public function sections() {
    	return $this->hasMany('App\Section');
    }
    
}
