<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 *
 * @property string redirectTo
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

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
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     * @throws
     */
    protected function attemptLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

        /*
         * Trying to authorize user
         */
        if (\Auth::attempt(['email' => $request->login, 'password' => $request->password], $request->filled('remember'))) {
            ActionLog::addRecord('login', false);

            auth()->user()->sendEmailNotification('login', [], true);
            return redirect($this->redirectTo);
        } elseif (\Auth::attempt(['login' => $request->login, 'password' => $request->password], $request->filled('remember'))) {
            ActionLog::addRecord('login', false);
            auth()->user()->sendEmailNotification('login', [], true);
            return redirect($this->redirectTo);
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * @param Request $request
     * @throws \Throwable
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
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
            : redirect('/');
    }
}
