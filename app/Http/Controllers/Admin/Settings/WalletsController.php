<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Currency;
use App\Models\PaymentSystem;
use Illuminate\Http\Request;

/**
 * Class WalletsController
 * @package App\Http\Controllers\Admin\Settings
 */
class WalletsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var PaymentSystem $paymentSystems */
        $paymentSystems = PaymentSystem::all();

        $paymentSystemModule = new PaymentSystem();
        $availablePaymentSystems = $paymentSystemModule->systems;

        foreach ($availablePaymentSystems as $code => $paymentSystem) {
            if(PaymentSystem::where('code', $code)->count() > 0) {
                unset($availablePaymentSystems[$code]);
            }
        }

        return view('admin.settings.wallets.index', [
            'paymentSystems'            => $paymentSystems,
            'availablePaymentSystems'   => $availablePaymentSystems,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $paymentSystemModule = new PaymentSystem();
        $availablePaymentSystems = $paymentSystemModule->systems;

        foreach ($availablePaymentSystems as $code => $paymentSystem) {
            if(PaymentSystem::where('code', $code)->count() > 0) {
                unset($availablePaymentSystems[$code]);
            }
        }

        return view('admin.settings.wallets.create', [
            'availablePaymentSystems' => $availablePaymentSystems,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $checkExists = PaymentSystem::where('code', $request->paymentSystemId)->count();

        if ($checkExists > 0) {
            session()->flash('error', __('this_wallet_already_registered'));
            return back();
        }

        $paymentSystemModule = new PaymentSystem();
        $availablePaymentSystems = $paymentSystemModule->systems;

        foreach ($availablePaymentSystems as $code => $paymentSystem) {
            if(PaymentSystem::where('code', $code)->count() > 0) {
                unset($availablePaymentSystems[$code]);
            }
        }

        $dataToCreate = $availablePaymentSystems[$request->paymentSystemId];

        /** @var PaymentSystem $reg */
        $reg = PaymentSystem::create([
            'name' => $dataToCreate['name'],
            'code' => $request->paymentSystemId
        ]);

        if (!$reg) {
            session()->flash('error', __('unable_register_wallet'));
            return back();
        }

        foreach ($dataToCreate['currencies'] as $currency) {
            /** @var Currency $currencyInfo */
            $currencyInfo = Currency::where('code', $currency)->first();

            if (empty($currencyInfo)) {
                continue;
            }

            \DB::table('currency_payment_system')->insert([
                'currency_id' => $currencyInfo->id,
                'payment_system_id' => $reg->id,
            ]);
        }

        session()->flash('success', __('wallet_created'));
        return redirect()->route('admin.settings.wallets.index');
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = PaymentSystem::findOrFail($id);

        $data = $request->all('paymentSystem');
        $data = $data['paymentSystem'];

        foreach ($data['settings'] as $key => $val) {
            $valueType = $paymentSystem->systems[$paymentSystem->code]['settings'][$key]; // show / hide

            if ($valueType == 'hide' && empty($val)) {
                unset($data['settings'][$key]);
            }
        }

        $paymentSystem->update($data);
        $moduleInstance = $paymentSystem->getClassInstance();

        try {
            $moduleInstance->getBalances();
        } catch (\Exception $e) {
            session()->flash('error', __('error').': '. $e->getMessage());
        }

        session()->flash('success', __('wallet_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id, Request $request)
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = PaymentSystem::findOrFail($id);
        $paymentSystem->delete();

        session()->flash('success', __('wallet_deleted'));
        return redirect()->route('admin.settings.wallets.index');
    }
}
