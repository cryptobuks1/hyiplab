<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestExchange;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class ExchangeMoneyController
 * @package App\Http\Controllers\Account
 */
class ExchangeMoneyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.exchange_money');
    }

    /**
     * @param RequestExchange $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(RequestExchange $request)
    {
        /** @var Wallet $fromWallet */
        $fromWallet = auth()->user()->wallets()->where('id', $request->wallet_from_id)->first();

        /** @var Wallet $toWallet */
        $toWallet = auth()->user()->wallets()->where('id', $request->wallet_to_id)->first();

        if (null == $fromWallet || null == $toWallet) {
            session()->flash('error', __('wallet_not_found'));
            return back();
        }

        $amount = (float) abs($request->amount);

        if ($amount <= 0) {
            session()->flash('error', __('amount_incorrect'));
            return back();
        }

        if ($fromWallet->id == $toWallet->id) {
            session()->flash('error', __('wallets_must_be_different'));
            return back();
        }

        $rate = Setting::getValue(strtolower($fromWallet->currency->code).'_to_'.strtolower($toWallet->currency->code), 0);

        if ($rate <= 0) {
            session()->flash('error', __('not_rate_found'));
            return back();
        }

        if ($fromWallet->balance < $amount) {
            session()->flash('error', __('insufficient_funds'));
            return back();
        }

        /** @var float $amountToReceive */
        $amountToReceive = round($amount*$rate, $toWallet->currency->precision);

        $fromWallet->balance -= $amount;
        $fromWallet->save();

        $toWallet->balance += $amountToReceive;
        $toWallet->save();

        Transaction::exchangeOut($fromWallet, $amount);
        Transaction::exchangeIn($toWallet, $amountToReceive);

        session()->flash('success', __('exchange_completed_your_credited').' '.$amountToReceive.$toWallet->currency->symbol);
        return back();
    }
}
