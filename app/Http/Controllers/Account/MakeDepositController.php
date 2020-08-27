<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCreateDeposit;
use App\Models\AutoCreateDeposit;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Rate;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class MakeDepositController
 * @package App\Http\Controllers\Account
 */
class MakeDepositController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->has('result')) {
            $result = $request->result;

            if ($result == 'ok') {
                session()->flash('success', __('payment_completed'));
            } else {
                session()->flash('error', __('payment_could_not_be_processed'));
            }
        }

        return view('account.make_deposit');
    }

    /**
     * @param RequestCreateDeposit $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function handle(RequestCreateDeposit $request)
    {
        if ($request->pay_from == 'payment_system') {
            return $this->handleWithPaymentSystem($request);
        }

        /** @var Wallet $wallet */
        $wallet = auth()->user()->wallets()->where('id', $request->wallet_id)->first();

        if (null == $wallet) {
            abort(404, 'wallet not found');
        }

        /** @var Rate $rate */
        $rate = Rate::find($request->rate_id);

        if (null == $rate) {
            abort(404, 'rate not found');
        }

        if ($wallet->currency_id != $rate->currency_id) {
            return back()->with('error', __('tariff_plan_and_wallet_currencies_must_match'));
        }

        $data = [
            'wallet_id' => $wallet->id,
            'rate_id' => $rate->id,
        ];

        $amount = (float) $request->amount;

        if ($wallet->balance < $amount) {
            return back()->with('error', __('insufficient_funds'));
        }

        if ($amount < $rate->min || $amount > $rate->max) {
            return back()->with('error', __('investment_amount_is_outside_of_tariff_plan'));
        }

        $data['amount'] = $amount;

        Deposit::createDeposit($data);

        session()->flash('success', __('deposit_created'));
        return redirect()->route('account.deposit-list');
    }

    /**
     * @param RequestCreateDeposit $request
     */
    public function handleWithPaymentSystem(RequestCreateDeposit $request)
    {
        $walletId = $request->wallet_id;
        $rateId = $request->rate_id;
        $amount = (float) $request->amount;

        /** @var Rate $rate */
        $rate = Rate::find($rateId);

        if (null === $rate) {
            return abort(403);
        }

        $user = auth()->user();

        /** @var Wallet $wallet */
        $wallet = $user->wallets()
            ->where('id', $walletId)
            ->first();

        if (null === $wallet) {
            return abort(403);
        }

        $currency = $wallet->currency;

        if (null === $currency) {
            return abort(403);
        }

        $paymentSystem = $wallet->paymentSystem;

        if (empty($paymentSystem)) {
            return abort(403);
        }

        $psMinimumTopupArray = @json_decode($paymentSystem->minimum_topup, true);
        $psMinimumTopup      = isset($psMinimumTopupArray[$currency->code])
            ? $psMinimumTopupArray[$currency->code]
            : 0;

        if ($request->amount < $psMinimumTopup) {
            return back()->with('error', __('minimum_amount_of_repl').' '.$psMinimumTopup.$currency->symbol)->withInput();
        }

        if ($amount < $rate->min || $amount > $rate->max) {
            return back()->with('error', __('investment_amount_is_outside_of_tariff_plan'));
        }

        AutoCreateDeposit::create([
            'wallet_id' => $wallet->id,
            'rate_id' => $rate->id,
            'amount' => $amount,
            'user_id' => $user->id,
        ]);

        session()->flash('buy.payment_system', $paymentSystem);
        session()->flash('buy.currency', $currency);
        session()->flash('buy.amount', $amount);

        return redirect()->route('account.buy.' . $paymentSystem->code);
    }
}
