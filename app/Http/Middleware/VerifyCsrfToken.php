<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Class VerifyCsrfToken
 * @package App\Http\Middleware
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/perfectmoney/status',
        '/payeer/status',
        '/coinpayments/status',
        '/free-kassa/status',
        '/yandex/status',
        '/qiwi/status',
        '/visa_mastercard/status',
        
        '/logout',
    ];
}
