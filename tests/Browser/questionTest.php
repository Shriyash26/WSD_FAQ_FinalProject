<?php

namespace Tests\Browser;

use App\Question;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;


class questionTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testpostNewQuestion(){

        $user = factory(User::class)->make([
            'email' => 'testuser@question.com',
        ]);
        $user->save();
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/home');
        });
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/home')
                ->clickLink('Create a Question')
                ->assertPathIs('/question/create')
                ->type('body', 'New question created')
                ->press('Save')
                ->assertPathIs('/home');
        });

        $question = Question::where('user_id',($user->id))->first();
        $this->browse(function ($browser) use ($user, $question) {
            $question_id = $question->id;
            $browser->visit('/home')
                ->clickLink('View')
                ->clickLink('Edit Question')
                ->type('body', 'New question edited')
                ->press('Save')
                ->assertRouteIs('question.show', ['id' => $question_id]);
        });

        $question->delete();
        $user->delete();

    }
}
