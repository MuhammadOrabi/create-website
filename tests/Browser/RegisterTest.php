<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegisterForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Register')
                    ->type('email', 'test@app.com')
                    ->type('name', 'Tester')
                    ->type('password', 'Tester')
                    ->type('password_confirmation', 'Tester')
                    ->press('register')
                    ->assertPathIs('/site/create');
        });
    }
}
