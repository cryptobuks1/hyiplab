<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Setting;
use Closure;

/**
 * Class SiteStatus
 * @package App\Http\Middleware
 */
class SiteStatus
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        if(!$admin && Setting::getValue('site-on') != '1' && !\Route::is('login') ){
            return response()->view('customer.disabled');
        }

        return $next($request);
    }
}
