<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSave()
    {
        $user = factory(\App\User::class)->make();
        $this->assertTrue($user->save());
    }
    public function testQuestions()
    {
        $user = factory(\App\User::class)->make();
        $this->assertTrue(is_object($user->questions()->get()));
    }
    public function testAnswers()
    {
        $user = factory(\App\User::class)->make();
        $this->assertTrue(is_object($user->answers()->get()));
    }
    public function testProfile()
    {
        $user = factory(\App\User::class)->make();
        $this->assertTrue(is_object($user->profile()->get()));
    }

    public function testLoginWithValidCredentials()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt($password = '111111'),
        ]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
    }

    public function testLoginFailWithInvalidCredentials()
    {
        $user = factory(\App\User::class)->create([
            'password' => bcrypt('111111'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'random',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

    }

    public function testTokenDatatype(){
        $user = User::inRandomOrder()->first();
        $this->assertInternalType('string',$user->token);
//        $this->artisan('migrate:refresh');

    }
}
