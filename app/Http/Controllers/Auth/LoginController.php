<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;

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

    use AuthenticatesUsers {
        logout as _logout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo() {
        return Session::pull('previous_url', RouteServiceProvider::HOME);
    }

    /**
     * Sets the previous URL in session if it doesn't exist
     */
    public function showLoginForm()
    {
        if(!Session::has('previous_url')){
            Session::put('previous_url', URL::previous());
        }

        return view('auth.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $this->_logout($request);

        return redirect(URL::previous());
    }
}
