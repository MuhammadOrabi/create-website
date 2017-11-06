<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activate extends Model
{
    protected $fillable = ['code'];
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
