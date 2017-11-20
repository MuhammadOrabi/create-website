<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function content()
    {
        return $this->belongsTo('App\Content');
    }
}
