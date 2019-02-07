<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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


    public function loginDuo(Request $request){
        $IKEY = env('DUO_IKEY');
        $SKEY = env('DUO_SKEY');
        $AKEY = env('DUO_AKEY');
        $HOST = env('DUO_HOST');

        if ($request->get('sig_response')) {
            $username = \App\Libraries\Web::verifyResponse($IKEY, $SKEY, $AKEY, $request->get('sig_response'));
            $credentials = [$this->username()=>$username];
            $user = \Auth::getProvider()->retrieveByCredentials($credentials);

            if ($user) {
                \Auth::login($user,$request->filled('remember'));
                $request->merge($credentials);
                return $this->sendLoginResponse($request);
            }
            return $this->sendFailedLoginResponse($request);
        }


        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if(\Auth::validate($this->credentials($request))){
            $sig_request = \App\Libraries\Web::signRequest($IKEY, $SKEY, $AKEY, $request->get($this->username()));
            return view('auth.duo_login',['sig_request'=>$sig_request,'host'=>$HOST,'host'=>$HOST,'remember'=>$request->get('remember')]);
        }
    }
}
