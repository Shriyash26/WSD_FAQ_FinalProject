<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'token' => str_random(40)
        ]);
        Mail::to($user->email)->send(new VerifyMail($user));

        return $user;
    }

    public function verifyUser($token)
    {
        $verifyUser = User::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser;
            if(!$user->email_verified_at) {
                $verifyUser->email_verified_at = date('Y-m-d H:i');
                $verifyUser->save();
                $status = "Your email is verified. You can now login.";
            }else{
                $status = "Your email is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('warning', "Oops! Email cannot be identified.");
        }

        return redirect('/login')->with('status', $status);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'We have sent verification link. Check your email and click on the link to verify.');
    }
}