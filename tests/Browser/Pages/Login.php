<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Login extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $user = factory(User::class)->create(['address' => 'main', 'password' => 'tester']);
        $browser->assertPathIs($this->url())
                    ->assertSee('Login')
                    ->type('email', $user->email)
                    ->type('password', 'tester')
                    ->press('login')
                    ->assertPathIsNot($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
