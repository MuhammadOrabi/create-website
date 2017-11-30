<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function contents()
    {
        return $this->morphMany('App\Content', 'contentable');
    }

    public function extras()
    {
        return $this->morphMany('App\Extra', 'extraable');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'logable');
    }
}
