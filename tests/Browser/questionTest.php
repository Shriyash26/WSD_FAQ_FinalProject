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
        //test to create new question
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/home')
                ->clickLink('Create a Question')
                ->assertPathIs('/question/create')
                ->type('body', 'New question created')
                ->press('Save')
                ->assertPathIs('/home');
        });
        //test to edit question
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
        //test to delete user question
        $this->browse(function ($browser) use ($user, $question) {
            $browser->visit('/home')
                ->clickLink('View')
                ->press('Delete')
                ->assertPathIs('/home');
        });

        $user->delete();
        $this->artisan('migrate:refresh');

    }
}
