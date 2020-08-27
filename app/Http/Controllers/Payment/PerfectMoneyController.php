<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Modules\PaymentSystems\PerfectMoneyModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PerfectMoneyController
 * @package App\Http\Controllers\Payment
 */
class PerfectMoneyController extends PaymentController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function topUp()
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = session('buy.payment_system');

        /** @var Currency $currency */
        $currency = session('buy.currency');

        if (empty($paymentSystem) || empty($currency)) {
            session()->flash('error', __('your_request_cannot_be_processed'));
            return back();
        }

        $amount = abs(session('buy.amount'));

        /** @var User $user */
        $user = auth()->user();

        /** @var Wallet $wallet */
        $wallet = $user->wallets()->where([
            ['currency_id', $currency->id],
            ['payment_system_id', $paymentSystem->id],
        ])->first();

        if (empty($wallet)) {
            $wallet = Wallet::newWallet($user, $currency, $paymentSystem);
        }

        if ($currency->code == 'USD') {
            $payeeAccount = $paymentSystem->getSetting('payee_account_usd');
        } elseif ($currency->code == 'EUR') {
            $payeeAccount = $paymentSystem->getSetting('payee_account_eur');
        } else {
            return redirect()->back()->with('error', __('invalid_currency'));
        }

        $payeeName   = $paymentSystem->getSetting('payee_name');
        $transaction = Transaction::enter($wallet, $amount);
        $comment     = $paymentSystem->getSetting('memo');

        return view('ps.perfectmoney', [
            'currency' => $currency->code,
            'amount' => $amount,
            'commission' => $transaction->type->commission*0.01*$amount,
            'payeeAccount' => $payeeAccount,
            'payeeName' => $payeeName,
            'statusUrl' => route('perfectmoney.status'),
            'user' => $user,
            'wallet' => $wallet,
            'paymentId' => strtoupper($transaction->id),
            'comment' => $comment,
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function status(Request $request)
    {
        if (!isset($request->PAYMENT_ID)
            || !isset($request->PAYEE_ACCOUNT)
            || !isset($request->PAYMENT_AMOUNT)
            || !isset($request->PAYMENT_UNITS)
            || !isset($request->PAYMENT_BATCH_NUM)
            || !isset($request->TIMESTAMPGMT)) {
            \Log::info('Perfectmoney. Bad request from: '.$request->ip().'. Entire request is: '.print_r($request->all(),true));
            return abort(400);
        }

        $ps = PaymentSystem::getByCode('perfectmoney');

        $psip = ['77.109.141.170','91.205.41.208','94.242.216.60','78.41.203.75','192.168.10.1'];

        if(!in_array($request->ip(), $psip)) {
            \Log::info('Got request to Perfectmoney status controller, from '.$request->ip().'. Allow requests only from: '.implode(', ', $psip));
            return abort(400);
        }

        $sciPassword = $ps->getSetting('sci_password');
        $checkHash = $request->PAYMENT_ID . ':' . $request->PAYEE_ACCOUNT . ':' . $request->PAYMENT_AMOUNT . ':' .
            $request->PAYMENT_UNITS . ':' . $request->PAYMENT_BATCH_NUM. ':' .
            $request->PAYER_ACCOUNT . ':' . strtoupper(md5($sciPassword)) . ':' . $request->TIMESTAMPGMT;
        $checkHash = strtoupper(md5($checkHash));

        if ($checkHash != $request->V2_HASH) {
            \Log::info('Perfectmoney hash is not passed. IP: '.$request->ip());
            return abort(400);
        }

        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = PaymentSystem::where('code', 'perfectmoney')->first();

        /** @var Currency $currency */
        $currency      = Currency::where('code', strtoupper($request->PAYMENT_UNITS))->first();

        if (null == $currency) {
            \Log::info('PerfectMoney. Bad request from: '.$request->ip().'. Currency not found. Entire request is: '.print_r($request->all(),true));
            return abort(400);
        }

        /** @var Transaction $transaction */
        $transaction = Transaction::where('id', strtolower($request->PAYMENT_ID))
            ->where('currency_id', $currency->id)
            ->where('payment_system_id', $paymentSystem->id)
            ->where('approved', 0)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();

        if (null == $transaction) {
            \Log::info('Bad request from: '.$request->ip().'. Transaction is not found. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        if ($transaction->amount > $request->PAYMENT_AMOUNT) {
            \Log::info('PerfectMoney. Bad request from: '.$request->ip().'. Amount less than in transaction. Entire request is: '.print_r($request->all(),true));
            return abort(400);
        }

        if ($transaction->result != 'COMPLETED' and $request->PAYMENT_BATCH_NUM) {
            $transaction->batch_id = $request->PAYMENT_BATCH_NUM;
            $transaction->result = 'COMPLETED';
            $transaction->source = $request->PAYER_ACCOUNT;
            $transaction->save();
            $commission = $transaction->amount * 0.01 * $transaction->commission;

            $transaction->wallet->refill(($transaction->amount-$commission), $transaction->source);
            $transaction->update(['approved' => true]);
            (new PerfectMoneyModule())->getBalances();
            return response('ok', 200);
        }

        \Log::info('Perfectmoney. Transaction is not passed. IP: '.$request->ip());
        return abort(400);
    }
}
