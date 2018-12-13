<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use App\User;


class verificationMailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testemailsent()
    {
        Mail::fake();
        $user  = User::create([
            'email' => 'shriyashmahajan@gmail.com',
            'password' => bcrypt('123456'),
            'token' => str_random(40)
        ]);
        $user->save();
//        dd($user->email);
        Mail::to($user->email)->send(new VerifyMail($user));
        Mail::assertSent(VerifyMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $response = $this->get(url('user/verify', $user->token));
        $response->assertStatus(302);
        $this->assertTrue($user->delete());
//         Mail::assertSent(VerifyMail::class);

    }
}
