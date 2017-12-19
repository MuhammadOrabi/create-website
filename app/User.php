<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Helpers\WebApps\ELearning\ELearningHelper;
use App\Helpers\Websites\Bizlight\BizlightHelper;
use App\Portfolios\Portfolio1\Portfolio1Helper;

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
        if ($site->theme->name == 'bizlight') {
            BizlightHelper::scaffold($site->id);
        } elseif ($site->theme->name == 'elearning') {
            ELearningHelper::scaffold($site->id);
        } elseif ($site->theme->name == 'elearning2') {
            ELearningHelper::scaffold($site->id);
        } elseif ($site->theme->name == 'theme1') {
            Portfolio1Helper::scaffold($site->id);
        }

        return $site;
    }

    public function getToken($name)
    {
        return $this->createToken($name)->accessToken;
    }
}
