<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded = [];

    // Site Reltionships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function theme()
    {
        return $this->belongsTo('App\Theme');
    }

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function imgs()
    {
        return $this->morphMany('App\Img', 'imgable');
    }

    public function extras()
    {
        return $this->morphMany('App\Extra', 'extraable');
    }

    public function constants()
    {
        return $this->hasMany('App\Constant');
    }

    public function logs()
    {
        return $this->morphToMany('App\Log', 'loggable');
    }

    // Helper methods
    public function addPage($page)
    {
        return $this->pages()->create($page);
    }

    public function addImage($url)
    {
        return $this->imgs()->create(compact('url'));
    }
}
