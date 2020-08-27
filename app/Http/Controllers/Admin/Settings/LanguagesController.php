<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class LanguagesController
 * @package App\Http\Controllers\Admin\Settings
 */
class LanguagesController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Language $languages */
        $languages = Language::where(null);

        if ($request->has('search')) {
            $languages->where(function($query) use($request) {
                $query->where('code', 'like', '%'.$request->search.'%');
            });
        }

        $languages = $languages->paginate(20);

        return view('admin.settings.languages.index', [
            'languages' => $languages,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Language $language */
        $language = Language::findOrFail($id);

        return view('admin.settings.languages.show', [
            'language' => $language,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.settings.languages.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkExists = Language::where('code', $request->language['code'])->count();

        if ($checkExists > 0) {
            session()->flash('error', __('this_language_already_registered'));
            return back();
        }

        if (empty($request->language['code'])) {
            session()->flash('error', __('fill_language_code'));
            return back();
        }

        $data = $request->all('language');
        $data = $data['language'];

        if ($data['default'] == 1) {
            Language::where('default', 1)->update(['default' => 0]);
        }

        /** @var Language $reg */
        $reg = Language::create($data);

        if (!$reg) {
            session()->flash('error', __('unable_to_register_language'));
            return back();
        }

        session()->flash('success', __('language_created'));
        return redirect()->route('admin.settings.languages.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Language $language */
        $language = Language::findOrFail($id);

        $data = $request->all('language');
        $data = $data['language'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');

        if ($data['default'] == 1) {
            Language::where('default', 1)
                ->where('id', '!=', $language->id)
                ->update(['default' => 0]);
        }

        $language->update($data);

        session()->flash('success', __('language_updated'));
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
        /** @var Language $language */
        $language = Language::findOrFail($id);
        $language->delete();

        session()->flash('success', __('language_deleted'));
        return redirect()->route('admin.settings.languages.index');
    }
}
