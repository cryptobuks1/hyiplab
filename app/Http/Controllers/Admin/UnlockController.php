<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;

/**
 * Class UnlockController
 * @package App\Http\Controllers\Admin
 */
class UnlockController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        return view('admin.auth.unlock', [
            'admin' => $admin,
        ]);
    }

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        if(!$request->has('password')) {
            abort(404);
        }

        $password = $request->password;

        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        if (true === \Hash::check($password, $admin->password)) {
            session(['last_visit' => now()->timestamp]);

            if (session()->has('last_page')) {
                return redirect(session('last_page'));
            } else {
                return redirect()->route('admin.dashboard');
            }
        } else {
            session()->flash('error', __('wrong_password'));
            return redirect(route('admin.unlock'));
        }
    }
}
