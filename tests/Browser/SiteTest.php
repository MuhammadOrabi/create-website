<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SiteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test CreateSite.
     *
     * @return void
     */
    public function testCreateSite()
    {
        $user = factory(User::class)->create(['address' => 'main']);

        $this->browse(function ($first, $seconed) use ($user) {
            $first->loginAs($user)
                    ->visit('/themes/create')
                    ->visit('/home')
                    ->assertPathIs('/site/create')
                    ->assertSee('Website')
                    ->click('@website')
                    ->waitFor('@bizlight')
                    ->click('@bizlight')
                    ->assertVueIsNot('id', 0, '@site-creator')
                    ->assertSee('Let\'s give your site an address.')
                    ->type('@address', 'mywebsite')
                    ->assertVue('address', 'mywebsite', '@site-creator')
                    ->pause(1000)
                    ->press('@create-site')
                    ->pause(10000)
                    ->assertPathBeginsWith('/dashboard');

            $seconed->loginAs($user)
                    ->visit('/site/create')
                    ->assertPathIs('/site/create')
                    ->assertSee('WebApp')
                    ->click('@webApp')
                    ->waitFor('@elearning')
                    ->click('@elearning')
                    ->assertVueIsNot('id', 0, '@site-creator')
                    ->assertSee('Let\'s give your site an address.')
                    ->type('@address', 'elearning')
                    ->assertVue('address', 'elearning', '@site-creator')
                    ->pause(1000)
                    ->press('@create-site')
                    ->pause(10000)
                    ->assertPathBeginsWith('/dashboard');
        });
    }
}
