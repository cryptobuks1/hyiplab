<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;

/**
 * Class ChooseTemplateController
 * @package App\Http\Controllers\Admin
 */
class ChooseTemplateController extends AdminController
{
    /**
     * @param string $template
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(string $template, Request $request)
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        if ($template != 'dark' && $template != 'light') {
            $admin->admin_template = null;
        } else {
            $admin->admin_template = $template;
        }

        $admin->save();

        return redirect()->route('admin.dashboard');
    }
}
