<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request) {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL) ? $this->username() : 'username';
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    protected function authenticated(Request $request, $user) {
        if (!$user->confirm) {
            auth()->logout();
            return back()->with('info', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        $previous_session = $user->session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }
        \Auth::user()->session_id = \Session::getId();
        \Auth::user()->save();
        return redirect()->intended($this->redirectPath());
    }
}
