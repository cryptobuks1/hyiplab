<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers;

use Carbon\Carbon;

/**
 * Class LanguageController
 * @package App\Http\Controllers
 */
class LanguageController extends Controller
{
    /**
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index($locale) {
        $locale      = preg_replace('/[^A-Za-z]/', '', trim($locale));
        $checkExists = file_exists(resource_path('lang/'.$locale.'.json'));

        if (false == $checkExists) {
            return back()->with('error', 'language is not found');
        }

        session([
            'language' => $locale
        ]);

        setcookie('language', $locale, Carbon::now()->addDays(365)->timestamp, '/');

        return back()->with('success', __('language_changed_to').' '.$locale);
    }

}
