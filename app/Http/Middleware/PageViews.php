<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use Closure;

/**
 * Class PageViews
 * @package App\Http\Middleware
 */
class PageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        /** @var PageViews $record */
        $record = \App\Models\PageViews::addRecord();

        /** @var User $user */
        $user = auth()->guard('web')->user();

        if (null !== $user && $user->isBlocked()) {
            die('Your account has been suspended.');
        }

        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        if (null !== $admin) {
            $limit = 60*5; // seconds

            if (session()->has('last_visit') && now()->timestamp - session('last_visit') > $limit) {
                if (!\Route::is('admin.unlock') && preg_match('/'.env('ADMIN_URL', 'admin').'/', $request->url)) {
                    session(['last_page' => $request->url()]);
                    return redirect(route('admin.unlock'));
                } else {
                    return $response;
                }
            }

            session(['last_visit' => now()->timestamp]);
        }

        return $response;
    }
}
