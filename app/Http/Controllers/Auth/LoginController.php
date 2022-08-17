<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'login';
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'login' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string'],
            'recaptcha' => ['recaptcha'],
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        $redirect_to = (Cookie::get('redirect_to')) ? Cookie::get('redirect_to') : 'service';
        Cookie::queue(Cookie::forget('redirect_to'));

        return redirect($redirect_to);
    }
}
