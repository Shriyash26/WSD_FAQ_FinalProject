<?php

namespace Tests\Browser;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class userProfileTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testUpdateUserProfile()
    {

        $NewUser = factory(User::class)->make([
            'email' => 'testAddProfile@test.com',
        ]);

        $NewUser->save();

        $this->browse(function ($browser) use ($NewUser) {

            $browser->visit('/login')
                ->type('email', $NewUser->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/home')
                ->clickLink('My Account')
                ->clickLink('Create Profile')
                ->type('fname','TestFirstName')
                ->type('lname','TestLastName')
                ->type('body','Test content for About Me')
                ->press('Save')
                ->assertPathIs('/home');
        });

        $NewUser->delete();
    }
}
