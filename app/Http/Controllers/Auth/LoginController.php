<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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
        $this->middleware('auth')->only('logout');
    }

    /**
     * Restrict login to admin only
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_admin) {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Only admin users can login.',
            ]);
        }

        // Redirect admins to admin dashboard
        return redirect()->intended('/admin');
    }
}