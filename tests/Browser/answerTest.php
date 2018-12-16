<?php

namespace Tests\Browser;
use App\Answer;
use App\Question;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class answerTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testAnswerFunctions()
    {
        $user = factory(User::class)->make([
            'email' => 'writeanswerToquestion@heroku.com',
        ]);
        $user->save();
        // test to post answer to question
        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/home')
                ->clickLink('Create a Question')
                ->assertPathIs('/question/create')
                ->type('body', 'New question')
                ->press('Save')
                ->assertPathIs('/home')
                ->clickLink('View')
                ->clickLink('Answer Question')
                ->type('body', 'Answer given to New question')
                ->press('Save')
                ->assertSee("Saved");
        });
        $question = Question::where('user_id',($user->id))->first();
        Answer::where('question_id',($question->id))->delete();
        $question->delete();
        $user->delete();

    }
}
