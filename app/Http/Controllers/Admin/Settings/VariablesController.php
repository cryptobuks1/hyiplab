<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Setting;
use Illuminate\Http\Request;

/**
 * Class VariablesController
 * @package App\Http\Controllers\Admin\Settings
 */
class VariablesController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Setting $settings */
        $settings = Setting::where(null);

        if ($request->has('search')) {
            $settings->where(function($query) use($request) {
                $query->where('s_key', 'like', '%'.$request->search.'%')
                    ->orWhere('s_value', 'like', '%'.$request->search.'%');
            });
        }

        $settings = $settings->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.settings.variables.index', [
            'settings' => $settings
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create( Request $request)
    {
        return view('admin.settings.variables.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all('setting');
        $data = $data['setting'];

        Setting::create($data);

        session()->flash('success', __('variable_created'));
        return redirect()->route('admin.settings.variables.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Setting $setting */
        $setting = Setting::findOrFail($id);

        $data = $request->all('setting');
        $data = $data['setting'];

        $setting->update($data);

        session()->flash('success', __('variable_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id, Request $request)
    {
        /** @var Setting $setting */
        $setting = Setting::findOrFail($id);
        $setting->delete();

        session()->flash('success', __('variable_deleted'));
        return redirect()->route('admin.settings.variables.index');
    }
}
