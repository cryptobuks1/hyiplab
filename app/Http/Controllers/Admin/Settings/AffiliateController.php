<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Referral;
use Illuminate\Http\Request;

/**
 * Class AffiliateController
 * @package App\Http\Controllers\Admin\Settings
 */
class AffiliateController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Referral $levels */
        $levels = Referral::orderBy('level')->get();

        return view('admin.settings.affiliate.index', [
            'levels' => $levels,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.settings.affiliate.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->all('level');
        $data = $data['level'];

        $checkExistsLevel = Referral::where('level', $data['level'])->count();

        if ($checkExistsLevel > 0) {
            session()->flash('error', __('this_level_already_registered'));
            return redirect()->route('admin.settings.affiliate.create');
        }

        Referral::create($data);

        session()->flash('success', __('level_created'));
        return redirect()->route('admin.settings.affiliate.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Referral $referral */
        $referral = Referral::findOrFail($id);

        $data = $request->all('level');
        $data = $data['level'];

        $referral->update($data);

        session()->flash('success', __('level_updated'));
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
        /** @var Referral $referral */
        $referral = Referral::findOrFail($id);
        $referral->delete();

        session()->flash('success', __('level_deleted'));
        return redirect()->route('admin.settings.affiliate.index');
    }
}
