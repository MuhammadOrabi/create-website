<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activate()
    {
        return $this->hasOne('App\Activate');
    }

    public function sites()
    {
        return $this->hasMany('App\Site');
    }

    public function extras()
    {
        return $this->morphMany('App\Extra', 'extraable');
    }

    public function imgs()
    {
        return $this->morphMany('App\Img', 'imgable');
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    // Helper Functions

    public function addSite($address, $theme_id)
    {
        $name = camel_case($address);
        $site = $this->sites()->create(compact('address', 'theme_id', 'name'));
        if ($site->theme->location == 'templates.websites.bizlight') {
            $site->bizlight_init();
        } elseif ($site->theme->location == 'templates.web-apps.elearning') {
            $site->sys_theme1_init();
        } elseif ($site->theme->location == 'templates.portfolios.theme1') {
            $site->portfolio_theme1_init();
        }

        return $site;
    }

    public function getToken($name)
    {
        return $this->createToken($name)->accessToken;
    }
}
