<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Rate;
use Illuminate\Http\Request;

/**
 * Class RatesController
 * @package App\Http\Controllers\Admin\Settings
 */
class RatesController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Rate $rates */
        $rates = Rate::all();

        return view('admin.settings.rates.index', [
            'rates' => $rates,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.settings.rates.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all('rate');
        $data = $data['rate'];

        if (empty($data['name'])) {
            session()->flash('error', __('name_is_required'));
            return redirect()->route('admin.settings.rates.create');
        }

        Rate::create($data);

        session()->flash('success', __('Rate created'));
        return redirect()->route('admin.settings.rates.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Rate $rate */
        $rate = Rate::findOrFail($id);

        $data = $request->all('rate');
        $data = $data['rate'];

        $rate->update($data);

        session()->flash('success', __('rate_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(string $id, Request $request)
    {
        /** @var Rate $rate */
        $rate = Rate::findOrFail($id);
        $rate->delete();

        session()->flash('success', __('rate_deleted'));
        return redirect()->route('admin.settings.rates.index');
    }
}
