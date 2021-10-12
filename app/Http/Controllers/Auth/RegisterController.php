<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserConfirm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Mail\RegisterUser;
use Mail;

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
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        $username = $data["username"];
        $email = $data["email"];
        $token = base64_encode(strtolower($email.'.'.str_random(10)));
        $roleName = "User";
        $confirmation = 0;

        $user = User::create([
            "username"=>$username,
            "email"=>$email,
            "password"=>bcrypt($data["password"]),
            "confirm"=> $confirmation,
            "access"=>json_encode([$roleName]),
            "remember_token"=>$token,
        ]);
        $user->assignRole($roleName);

        UserConfirm::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        Mail::to($user->email)->send(new RegisterUser($user));

        return $user;
    }

    protected function registered(Request $request, $user) {
        $this->guard()->logout();
        return redirect('/login')->with('info', 'You need to confirm your account. We have sent you an activation code, please check your email.');
       
    }

    public function verify($token){
        $userConfirm = UserConfirm::where("token", $token)->first();
        if(!is_null($userConfirm)){
            $user = $userConfirm->user;
            $message = null;
            if(!$user->confirm){
                $userConfirm->user->confirm = 1;
                $userConfirm->user->save();
                $message = "Your e-mail is verified. You can now login.";
            }else{
                $message = "Your e-mail is already verified. You can now login.";
            }
            return redirect('/login')->with('success', $message);
        }   
        return abort(404);   
    }
}
