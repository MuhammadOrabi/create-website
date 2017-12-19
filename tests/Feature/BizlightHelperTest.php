<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Theme;
use App\Site;
use App\User;
use App\Helpers\Websites\Bizlight\BizlightHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BizlightHelperTest extends TestCase
{
    use RefreshDatabase;

    /**
    * A basic test example.
    *
    * @return void
    */
    public function scaffoldTest()
    {
        $theme = Theme::where('location', 'templates.websites.bizlight')->first();
        $user = factory(User::class)->make()->each(function ($u) {
            $site = $u->sites()->save(factory(Site::class)->make(['theme_id' => $theme->id]));
            BizlightHelper::scaffold($site->id);
        });
    }
}
