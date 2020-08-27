<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Spatie\RobotsMiddleware\RobotsMiddleware;

/**
 * Class MyRobotsMiddleware
 * @package App\Http\Middleware
 */
class MyRobotsMiddleware extends RobotsMiddleware
{
    /**
     * @param Request $request
     * @return bool|string
     */
    protected function shouldIndex(Request $request)
    {
        return $request->segment(1) !== env('ADMIN_URL', 'admin')
            && (config('app.env') == 'production' || config('app.env') == 'demo');
    }
}