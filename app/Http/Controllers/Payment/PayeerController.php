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
use App\Modules\PaymentSystems\PayeerModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PayeerController
 * @package App\Http\Controllers\Payment
 */
class PayeerController extends PaymentController
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

        if (null === $transaction) {
            return redirect()->back()->with('error', __('Enter transaction not found.'));
        }

        $transaction->source = substr(preg_replace('/[^0-9]/', '', $transaction->id), 0, 6);
        $transaction->save();

        $merchantId   = $paymentSystem->getSetting('merchant_id');
        $orderId      = $transaction->source;
        $amount       = number_format($amount, 2, '.', '');
        $currencyCode = $currency->code;
        $memo         = base64_encode($paymentSystem->getSetting('memo'));

        // Forming an array for signature generation
        $arHash = [
            $merchantId,
            $orderId,
            $amount,
            $currencyCode,
            $memo,
        ];

        $arHash[]  = $paymentSystem->getSetting('merchant_key');
        $signature = strtoupper(hash('sha256', implode(":", $arHash)));

        \Log::info('payeer: '.print_r($arHash,true));

        return view('ps.payeer', [
            'currency'   => $currencyCode,
            'amount'     => $amount,
            'user'       => $user,
            'wallet'     => $wallet,
            'merchantId' => $merchantId,
            'comment'    => $memo,
            'orderId'  => $orderId,
            'paymentId'  => $orderId,
            'signature'  => $signature,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function status(Request $request)
    {
        if (!$request->has('m_operation_id')
            || !$request->has('m_operation_ps')
            || !$request->has('m_operation_date')
            || !$request->has('m_operation_pay_date')
            || !$request->has('m_shop')
            || !$request->has('m_orderid')
            || !$request->has('m_curr')
            || !$request->has('m_desc')
            || !$request->has('m_status')
            || !$request->has('m_sign')) {
            \Log::info('Payeer. Bad request from: '.$request->ip().'. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        $ips = [
            '185.71.65.92',
            '185.71.65.189',
            '149.202.17.210'
        ];

        if (!in_array($request->ip(), $ips)) {
            \Log::info('Got request to Payeer status controller, from '.$request->ip().'. Allow requests only from: '.implode(', ', $ips));
            return response('ok');
        }

        $m_key = config('money.payeer_merchant_key');

        $arHash = array(
            $request->m_operation_id,
            $request->m_operation_ps,
            $request->m_operation_date,
            $request->m_operation_pay_date,
            $request->m_shop,
            $request->m_orderid,
            $request->m_amount,
            $request->m_curr,
            $request->m_desc,
            $request->m_status,
        );

        if ($request->has('m_params')) {
            $arHash[] = $request->m_params;
        }

        $arHash[]  = $m_key;
        $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

        $currencyCode = $request->m_curr;

        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = PaymentSystem::where('code', 'payeer')->first();

        /** @var Currency $currency */
        $currency      = Currency::where('code', strtoupper($currencyCode))->first();

        if (null == $currency) {
            \Log::info('Payeer. Bad request from: '.$request->ip().'. Currency not found. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        /** @var Transaction $transaction */
        $transaction = Transaction::where('source', strtolower($request->m_orderid))
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

        if ($transaction->result != 'success' && $request->m_sign == $sign_hash && $request->m_status == 'success') {
            $transaction->batch_id = $request->m_orderid;
            $transaction->result = 'success';
            $transaction->source = '';
            $transaction->save();
            $commission = $transaction->amount * 0.01 * $transaction->commission;

            $transaction->wallet->refill(($transaction->amount-$commission), $transaction->source);
            $transaction->update(['approved' => true]);
            (new PayeerModule())->getBalances();
            return response('ok');
        }

        \Log::info('Payeer hash is not passed. IP: '.$request->ip());
        return response('ok');
    }
}
