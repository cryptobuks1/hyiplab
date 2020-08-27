<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AdminLoginController
 * @package App\Http\Controllers\Admin\Auth
 */
class AdminLoginController extends Controller
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

    protected $guard = 'admin';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = env('ADMIN_URL', 'admin');
    }

    public function showLoginForm()
    {
        if (\Auth::guard('admin')->user()) {
            return redirect($this->redirectTo);
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

        if (auth()->guard('admin')->attempt(['login' => $request->login, 'password' => $request->password])) {
            ActionLog::addRecord('login', false);
            return redirect($this->redirectTo);
        }

        return back()->withErrors(['email' => __('data_incorrect')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Response|\Illuminate\Routing\Redirector|mixed
     */
    public function logout(Request $request)
    {
        ActionLog::addRecord('logout');

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/'.env('ADMIN_URL', 'admin'));
    }
}