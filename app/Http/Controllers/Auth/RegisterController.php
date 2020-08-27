<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/account';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'login' => 'string|max:30|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'partner_id' => 'nullable|digits:6|exists:users,my_id',
            'agreement' => 'required',
        ]);
    }

    /**
     * @param array $data
     * @return User
     * @throws \Throwable
     */
    protected function create(array $data)
    {
        if (isset($_COOKIE['partner_id'])) {
            $partner_id = $_COOKIE['partner_id'];
        } elseif (isset($data['partner_id'])) {
            $partner_id = $data['partner_id'];
        } else {
            $partner_id = null;
        }

        /** @var User|null $partner */
        $partner = null !== $partner_id
            ? User::where('my_id', $partner_id)
            : null;

        if (empty($data['login'])) {
            $data['login'] = $data['email'];
        }

        $myId = generateMyId();

        /** @var User $user */
        $user = User::create([
            'name'       => $data['name'] ?? '',
            'email'      => $data['email'],
            'login'      => $data['login'],
            'password'   => bcrypt($data['password']),
            'partner_id' => null !== $partner ? $partner->my_id : null,
            'my_id'      => $myId,
        ]);

        if (null !== $partner) {
            $partner->sendEmailNotification('ref_registration', ['ref' => $user], true);
        }

        return $user;
    }
}
