<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class Bizlight extends DuskTestCase
{
    /**
     * A Dusk test .
     *
     * @return void
     */
    public function test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
