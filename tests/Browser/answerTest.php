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
                ->assertSee("Saved")
                ->clickLink('View')       // Edit answer
                ->clickLink('Edit Answer')
                ->type('body', 'Answer to new Question updated')
                ->press('Save')
                ->assertSee("Updated")
                ->press('Delete')       // delete answer
                ->assertSee("Delete");
        });


        $question = Question::where('user_id',($user->id))->first();
        $question->delete();
        $user->delete();

    }

    public function testOnlyOwnerCanEditOrDeleteAnswer(){
        $user1 = factory(User::class)->make([
            'email' => 'UserOne@ans.com',
        ]);
        $user1->save();

        $user2 = factory(User::class)->make([
            'email' => 'UserTwo@ans.com',
        ]);
        $user2->save();

        $this->browse(function ($browser) use ($user1, $user2) {
            $browser->visit('/login')
                ->type('email', $user1->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/home')
                ->clickLink('Create a Question')
                ->assertPathIs('/question/create')
                ->type('body', 'New Question added')
                ->press('Save')
                ->assertPathIs('/home')
                ->clickLink('View')
                ->clickLink('Answer Question')
                ->type('body', 'Answer added to user1 question')
                ->press('Save')
                ->clickLink('My Account')
                ->clickLink('Logout')
                ->assertPathIs('/')
                ->clickLink('Login')
                ->type('email', $user2->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/home')
                ->clickLink('View')
                ->clickLink('View')
                ->assertDontSee('Edit Answer')
                ->assertDontSee('Delete');

        });

        $question = Question::where('user_id',($user1->id))->first();
        Answer::where('question_id',($question->id))->delete();
        $question->delete();
        $user1->delete();
        $user2->delete();

    }
}
