<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Helpers\WebApps\WebAppsHelper;
use App\Helpers\Websites\WebsitesHelper;
use Illuminate\Notifications\Notifiable;
use App\Helpers\Portfolios\PortfoliosHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Blogs\BlogsHelper;

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
        return $this->morphToMany('App\Log', 'loggable');
    }

    // Helper Functions

    public function addSite($address, $theme_id)
    {
        $name = camel_case($address);
        $site = $this->sites()->create(compact('address', 'theme_id', 'name'));
        $tag = $site->theme->tags()->where('type', 'category')->first();
        if ($tag->tag === 'website') {
            return WebsitesHelper::finder($site, null, 'scaffold');
        } elseif ($tag->tag === 'portfolio') {
            return PortfoliosHelper::finder($site, null, 'scaffold');
        } elseif ($tag->tag === 'web application') {
            return WebAppsHelper::finder($site, null, 'scaffold');
        } elseif ($tag->tag === 'blog') {
            return BlogsHelper::finder($site, null, 'scaffold');    
        }

        return $site;
    }

    public function getToken($name)
    {
        return $this->createToken($name)->accessToken;
    }
}
