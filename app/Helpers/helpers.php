<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

/**
 * @param array $keys
 * @return void
 * @throws Exception
 */
function clearCacheByArray(array $keys)
{
    foreach ($keys as $key) {
        cache()->forget($key);
    }
}

/**
 * @param array $tags
 * @return void
 * @throws Exception
 */
function clearCacheByTags(array $tags)
{
    cache()->tags($tags)->flush();
}

/**
 * @return int
 */
function generateMyId(): int
{
    $maxExists = \App\Models\User::max('my_id');
    $maxExists = $maxExists > 0
        ? $maxExists+1
        : rand(500000, 2000000);

    return $maxExists;
}

/**
 * @return string
 */
function getSupervisorName()
{
    return preg_replace('/ /', '-', env('APP_NAME', 'supervisor-1'));
}

/**
 * @param float $amount
 * @param \App\Models\Currency $currency
 * @param string $thousands_sep
 * @return string
 */
function amountWithPrecision(float $amount, \App\Models\Currency $currency, $thousands_sep='')
{
    return round($amount, $currency->precision);
}

/**
 * @param float $amount
 * @param string $currencyCode
 * @param string $thousands_sep
 * @return string
 */
function amountWithPrecisionByCurrencyCode(float $amount, string $currencyCode, $thousands_sep='')
{
    /** @var \App\Models\Currency $currency */
    $currency = \App\Models\Currency::where('code', $currencyCode)
        ->first();

    return round($amount, $currency->precision);
}

function convertToCurrency(\App\Models\Currency $fromCurrency, \App\Models\Currency $toCurrency, float $amount)
{
    if (null === $fromCurrency || null === $toCurrency || $amount <= 0) {
        return 0;
    }

    // FIAT: USD, EUR, RUB
    // CRYPTO: BTC, LTC, ETH

    $rate = \App\Models\Setting::getValue(strtolower($fromCurrency->code).'_to_'.strtolower($toCurrency->code));

    return amountWithPrecision($rate*$amount, $toCurrency);
}

function activeGuard(){

    foreach(array_keys(config('auth.guards')) as $guard){
        if(auth()->guard($guard)->check()) return $guard;
    }

    return null;
}

/**
 * @return \Illuminate\Contracts\Auth\Authenticatable|null
 */
function admin()
{
    return auth()->guard('admin')->user();
}

/**
 * @param string $route
 * @return mixed
 */
function hasAccessTo(string $route)
{
    $admin = admin();

    if (null == $admin) {
        return false;
    }

    return admin()->hasPermissionTo($route);
}

/**
 * @return string
 */
function getCurrentAdminTemplate()
{
    $default = 'dark';

    /** @var \App\Models\Admin $admin */
    $admin = auth()->guard('admin')->user();

    if (null == $admin || null == $adminTemplate = $admin->admin_template) {
        return $default;
    }

    return $adminTemplate;
}