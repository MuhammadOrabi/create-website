<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];
    public function section() {
    	return $this->belongsTo('App\Section');
    }
    public function extras() {
        return $this->hasMany('App\Extra');
    }
    public function constant() {
    	return $this->belongsTo('App\Constant');
    }
}
