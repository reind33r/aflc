<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
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

    protected $username;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:web:organizers')->except('logout');
        $this->username = $this->findUsername();
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

    public function showOrganizerLoginForm()
    {
        return view('auth.login_organizer');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $this->_logout($request);

        return redirect(URL::previous());
    }

    /**
     * Get the login username to be used by the controller.
     *
     */
    public function findUsername() {
        if(request()->has('email')) {
            return 'email';
        }

        $login = request()->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username() {
        return $this->username;
    }


    protected function guard() {
        switch(request()->input('guard')) {
            case 'organizer':
                return Auth::guard('web:organizers');
            break;
            default:
                return Auth::guard();
            break;
        }
    }
}
