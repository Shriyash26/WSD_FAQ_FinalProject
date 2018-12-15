<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class loginAuthTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginAuth()
    {
        $user = factory(User::class)->make([
            'email' => 'abcdef@abc.com',
        ]);
        $user->save();
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/home');
        });
        $user->delete();
    }

    public function testUserRegisteration(){

        $this->browse(function ($browser)  {
            $browser->visit('/register')
                ->type('email', 'shriyashmahajan@gmail.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Register');

        });
        $user = User::where('email','shriyashmahajan@gmail.com')->first();
        $this->browse(function ($browser) use ($user) {
            $userToken= $user->token;
            $browser->visit(url('user/verify', $userToken))
            ->assertPathIs('/login');
        });

        $user->delete();
    }
}
