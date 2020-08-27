<?php


namespace App\Http\Controllers;

use App\Models\User;
use Validator;

class SetPartnerController extends Controller
{
    /**
     * @param $partner_id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function index($partner_id)
    {
        $check['partner_id'] = trim($partner_id);

        $validator = Validator::make($check, [
            'partner_id' => 'required|exists:users,my_id',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator);
        }

        setcookie("partner_id", $partner_id, time()+2592000, '/'); // expire in 30 days
        return redirect(route('register'));
    }
}
