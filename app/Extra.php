<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $guarded = [];
    public function user() {
        $this->belongsTo('App\User');
    }
    public function site() {
        $this->belongsTo('App\Site');
    }
    public function section() {
        $this->belongsTo('App\Section');
    }
    public function content() {
        $this->belongsTo('App\Content');
    }
}
