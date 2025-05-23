<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuctionUserController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (Auth::user()) {
            if(!Auth::user()->isAdmin()){
                Auth::logout();
                return redirect()->route('login');
            }

            if($request->has('redirect_url') AND $request->has('user_id') AND $request->redirect_url AND $request->user_id){
                $redirectUrl = $request->redirect_url ;
                return Redirect::away($redirectUrl);
            }
        }

    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
