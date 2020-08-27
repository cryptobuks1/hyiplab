<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class CurrenciesController
 * @package App\Http\Controllers\Admin\Settings
 */
class CurrenciesController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Currency $currencies */
        $currencies = Currency::where(null);

        if ($request->has('search')) {
            $currencies->where(function($query) use($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%');
            });
        }

        $currencies = $currencies->paginate(20);

        $currencyModel = new Currency();
        $availableCurrencies = $currencyModel->currencies;

        foreach ($availableCurrencies as $code => $currency) {
            if(Currency::where('code', $code)->count() > 0) {
                unset($availableCurrencies[$code]);
            }
        }

        return view('admin.settings.currencies.index', [
            'currencies' => $currencies,
            'availableCurrencies' => $availableCurrencies,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Currency $currency */
        $currency = Currency::findOrFail($id);

        return view('admin.settings.currencies.show', [
            'currency' => $currency,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $currencyModel = new Currency();
        $availableCurrencies = $currencyModel->currencies;

        foreach ($availableCurrencies as $code => $currency) {
            if(Currency::where('code', $code)->count() > 0) {
                unset($availableCurrencies[$code]);
            }
        }

        return view('admin.settings.currencies.create', [
            'availableCurrencies' => $availableCurrencies,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkExists = Currency::where('code', $request->currencyCode)->count();

        if ($checkExists > 0) {
            session()->flash('error', __('this_currency_already_registered'));
            return back();
        }

        $currencyModel = new Currency();
        $availableCurrencies = $currencyModel->currencies;

        foreach ($availableCurrencies as $code => $currency) {
            if(Currency::where('code', $code)->count() > 0) {
                unset($availableCurrencies[$code]);
            }
        }

        $dataToCreate = $availableCurrencies[$request->currencyCode];
        $dataToCreate = array_merge(['code' => $request->currencyCode], $dataToCreate);

        /** @var Currency $reg */
        $reg = Currency::create($dataToCreate);

        if (!$reg) {
            session()->flash('error', __('unable_to_register_currency'));
            return back();
        }

        session()->flash('success', __('currency_created'));
        return redirect()->route('admin.settings.currencies.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Currency $currency */
        $currency = Currency::findOrFail($id);

        $data = $request->all('currency');
        $data = $data['currency'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');

        $currency->update($data);

        session()->flash('success', __('currency_updated'));
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
        /** @var Currency $currency */
        $currency = Currency::findOrFail($id);
        $currency->delete();

        session()->flash('success', __('currency_deleted'));
        return redirect()->route('admin.settings.currencies.index');
    }
}
