<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];

    public function contentable()
    {
        return $this->morphTo();
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
