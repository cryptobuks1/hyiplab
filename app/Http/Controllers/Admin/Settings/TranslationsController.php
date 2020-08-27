<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;

/**
 * Class TranslationsController
 * @package App\Http\Controllers\Admin\Settings
 */
class TranslationsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $languages = $this->getLanguages();
        $defaultTranslations = $this->getDefaultTranslations();
        $allTranslations = $this->getAllTranslations($languages);

        if ($request->has('search')) {
            $searchKey = trim($request->search);

            $doNotRemove = [];
            $listToRemove = [];

            foreach ($allTranslations as $lang => $blockLang) {
                foreach ($blockLang as $key => $translation) {
                    try {
                        if (!preg_match('/' . $searchKey . '/', $translation) && !preg_match('/' . $searchKey . '/', $key)) {
                            $listToRemove[] = $key;
                        } else {
                            $doNotRemove[] = $key;
                        }
                    } catch (\Exception $e) {
                        session()->flash('error', __('do_not_use_special_characters'));
                    }
                }
            }

            foreach ($listToRemove as $toRemove) {
                if (!in_array($toRemove, $doNotRemove)) {
                    unset($defaultTranslations[$toRemove]);
                }
            }
        }

        $page = $request->page ?? 1;

        $defaultTranslations = collect($defaultTranslations);

        if ($page > 1) {
            $defaultTranslations = $defaultTranslations->skip($page*30-30);
        }

        $defaultTranslations = $defaultTranslations->take(30);

        $allTranslations = collect($allTranslations);
        $languages = collect($languages);

        return view('admin.settings.translations.index', [
            'defaultTranslations'   => $defaultTranslations,
            'allTranslations'       => $allTranslations,
            'languages'             => $languages,
        ]);
    }

    /**
     * @param string $key
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $key, Request $request)
    {
        $languages = $this->getLanguages();
        $allTranslations = $this->getAllTranslations($languages);

        foreach ($request->language as $oldKey => $translations) {
            $setKey             = '';
            $setTranslation     = [];

            foreach ($translations as $key => $content) {
                if (empty($key) || empty($content)) {
                    session()->flash('error', 'Ключ или перевод пустой');
                    return back();
                }

                if ($key == 'key') {
                    $setKey = $content;
                    continue;
                }

                $setTranslation[$key] = $content;
            }

            foreach ($languages as $language) {
                unset($allTranslations[$language][$oldKey]);

                if (!$request->has('destroy')) {
                    $allTranslations[$language][$setKey] = $setTranslation[$language];
                }
            }
        }

        foreach ($allTranslations as $lang => $fileTranslation) {
            if (empty($fileTranslation)) {
                $fileTranslation = [];
            }

            $encodedFileTranslation = json_encode($fileTranslation);
            file_put_contents(resource_path('lang/' . $lang . '.json'), $encodedFileTranslation);
        }

        session()->flash('success', __('translation_updated'));
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $languages = $this->getLanguages();
        $allTranslations = $this->getAllTranslations($languages);

        $setKey             = '';
        $setTranslation     = [];

        foreach ($request->language as $key => $content) {
            if (empty($key) || empty($content)) {
                session()->flash('error', 'Ключ или перевод пустой');
                return back();
            }

            if ($key == 'key') {
                $setKey = $content;
                continue;
            }

            $setTranslation[$key] = $content;
        }

        foreach ($languages as $language) {
            if (isset($allTranslations[$language][$setKey])) {
                session()->flash('error', __('this_key_already_registered'));
                return back();
            }
            $allTranslations[$language][$setKey] = $setTranslation[$language];
        }

        foreach ($allTranslations as $lang => $fileTranslation) {
            if (empty($fileTranslation)) {
                $fileTranslation = [];
            }

            $encodedFileTranslation = json_encode($fileTranslation);
            file_put_contents(resource_path('lang/' . $lang . '.json'), $encodedFileTranslation);
        }

        session()->flash('success', __('translation_created'));
        return back();
    }

    /**
     * @param array $languages
     * @return array
     */
    private function getAllTranslations(array $languages)
    {
        $allTranslations = [];

        foreach ($languages as $language) {
            $file = file_get_contents(resource_path('lang/' . $language . '.json'));

            if (!empty($file)) {
                $allTranslations[$language] = json_decode($file, true);
            }
        }

        return $allTranslations;
    }

    /**
     * @return array
     */
    private function getLanguages()
    {
        $languages  = [];
        $scans      = scandir(resource_path('lang/'));

        foreach ($scans as $scan) {
            if (preg_match('/\.json/', $scan)) {
                $languages[] = preg_replace('/\.json/', '', $scan);
            }
        }

        return $languages;
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    private function getDefaultTranslations()
    {
        $defaultLang = Language::where('default', 1)->first();
        $defaultLang = $defaultLang !== null
            ? $defaultLang->code
            : 'en';
        $path = resource_path('lang/' . $defaultLang . '.json');

        if (!file_exists($path)) {
            session()->flash('error','Translation error. lang/'.$defaultLang.'.json is not exists.');
            $path = resource_path('lang/en.json');
        }

        $file = file_get_contents($path);

        $defaultTranslations = [];

        if (!empty($file)) {
            $defaultTranslations = json_decode($file, true);
        }

        return $defaultTranslations;
    }
}
