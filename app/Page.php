<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function sections()
    {
        return $this->hasMany('App\Section');
    }

    public function logs()
    {
        return $this->morphToMany('App\Log', 'loggable');
    }

    public function contents()
    {
        return $this->hasManyThrough('App\Content', 'App\Section', 'page_id', 'contentable_id');
    }
}
