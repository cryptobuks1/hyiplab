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
use App\Modules\PaymentSystems\CoinpaymentsModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CoinpaymentsController
 * @package App\Http\Controllers\Payment
 */
class CoinpaymentsController extends PaymentController
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

        $transaction = Transaction::enter($wallet, $amount);

        try {
            $coinpayments = new CoinpaymentsModule();
            $topupTransaction = $coinpayments->createTopupTransaction($transaction);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return view('ps.coinpayments', [
            'currency'       => $currency,
            'transaction'    => $transaction,
            'user'           => $user,
            'wallet'         => $wallet,
            'paymentSystem'  => $paymentSystem,
            'receiveAddress' => $topupTransaction['address'],
            'confirmsNeeded' => $topupTransaction['confirms_needed'],
            'timeout'        => $topupTransaction['timeout'],
            'buyerStatusUrl' => $topupTransaction['status_url'],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function status(Request $request)
    {
        $ps = PaymentSystem::getByCode('coinpayments');

        $merchant_id = $ps->getSetting('merchant_id');
        $secret      = $ps->getSetting('ipn_secret');

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            \Log::info('Coinpayments. Bad request from: '.$request->ip().', No HMAC signature sent. '.print_r($request->all(),true));
            return response('ok');
        }

        $merchant = $request->has('merchant') ? $request->merchant : '';

        if (empty($merchant)) {
            \Log::info('Coinpayments. Bad request from: '.$request->ip().', No Merchant ID passed. '.print_r($request->all(),true));
            return response('ok');
        }

        if ($merchant != $merchant_id) {
            \Log::info('Coinpayments. Bad request from: '.$request->ip().', Invalid Merchant ID. '.print_r($request->all(),true));
            return response('ok');
        }

        $rawRequest = file_get_contents('php://input');

        if ($rawRequest === FALSE || empty($rawRequest)) {
            \Log::info('Coinpayments. Bad request from: '.$request->ip().', Error reading POST data. '.print_r($request->all(),true));
            return response('ok');
        }

        $hmac = hash_hmac("sha512", $rawRequest, $secret);

        if ($hmac != $_SERVER['HTTP_HMAC']) {
            \Log::info('Coinpayments. Bad request from: '.$request->ip().', HMAC signature does not match. '.print_r($request->all(),true));
            return response('ok');
        }

        if (!$request->has('amount1') ||
            !$request->has('currency1') ||
            !$request->has('status') ||
            !$request->has('txn_id') ||
            !$request->has('invoice')) {
            \Log::info('Coinpayments. Bad request from: '.$request->ip().'. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = PaymentSystem::where('code', 'coinpayments')->first();
        /** @var Currency $currency */
        $currency      = Currency::where('code', strtoupper($request->currency1))->first();

        if (null == $currency) {
            \Log::info('Bad request from: '.$request->ip().'. Currency not found. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        /** @var Transaction $transaction */
        $transaction = Transaction::where('id', $request->invoice)
            ->where('approved', 0)
            ->where('currency_id', $currency->id)
            ->where('payment_system_id', $paymentSystem->id)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();

        if (null == $transaction) {
            \Log::info('Bad request from: '.$request->ip().'. Transaction is not found. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        if ($transaction->result != 'complete' && $request->status >= 100 && $request->status_text == 'Complete') {
            $transaction->batch_id = $request->txn_id;
            $transaction->result = 'complete';
            $transaction->source = '';
            $transaction->save();
            $commission = $transaction->amount * 0.01 * $transaction->commission;

            $transaction->wallet->refill(($transaction->amount-$commission), $transaction->source);
            $transaction->update(['approved' => true]);
            (new CoinpaymentsModule())->getBalances();
            return response('ok');
        }

        \Log::emergency('Coinpayments transaction is not passed. IP: '.$request->ip().'. '.print_r($request->all()));
        return response('ok');
    }
}
