<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Payment;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class FreeKassaController
 * @package App\Http\Controllers\Payment
 */
class FreeKassaController extends PaymentController
{
    /** @var string $psCode */
    protected $psCode = 'free-kassa';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function topUp()
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = session('buy.payment_system');

        /** @var Currency $currency */
        $currency = session('buy.currency');

        $i = session('buy.i');

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
            return redirect()->route('account.topup')->with('error', __('Enter transaction not found.'));
        }

        $transaction->source = preg_replace('/[^0-9]/', '', $transaction->id);
        $transaction->save();

        $merchantId   = $paymentSystem->getSetting('merchant_id');
        $orderId      = $transaction->source;
        $amount       = round($amount, 2);
        $currencyCode = $currency->code;
        $memo         = $paymentSystem->getSetting('memo');

        // Forming an array for signature generation
        $signature = md5($merchantId.':'.$amount.':'.$paymentSystem->getSetting('merchant_key').':'.$orderId);

        return view('ps.'.$this->psCode, [
            'currency'   => $currencyCode,
            'amount'     => $amount,
            'user'       => $user,
            'wallet'     => $wallet,
            'merchantId' => $merchantId,
            'comment'    => $memo,
            'orderId'  => $orderId,
            'signature'  => $signature,
            'i'          => $i,
        ]);
    }

    public static function getIP() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function status(Request $request)
    {
        $ps = PaymentSystem::getByCode('free-kassa');

        $merchant_id = $ps->getSetting('merchant_id');
        $merchant_secret = $ps->getSetting('merchant_key');

        if (!in_array(self::getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
            \Log::info('Not correct IP from FreeKassa');
            die("hacking attempt!");
        }

        $sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

        if ($sign != $_REQUEST['SIGN']) {
            \Log::info('Wrong sign from FreeKassa');
            die('wrong sign');
        }

        /** @var Transaction $transaction */
        $transaction = Transaction::where('source', strtolower($_REQUEST['MERCHANT_ORDER_ID']))
            ->where('approved', 0)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();

        if (null == $transaction) {
            \Log::info('Bad request from: '.$request->ip().'. Transaction is not found. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = $transaction->paymentSystem;

        /** @var Currency $currency */
        $currency      = $transaction->currency;

        if (null == $currency) {
            \Log::info('FreeKassa. Bad request from: '.$request->ip().'. Currency not found. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        if ((float) $_REQUEST['AMOUNT'] < $transaction->amount) {
            \Log::info('FreeKassa. Bad request from: '.$request->ip().'. Amount is not the same with transaction. Entire request is: '.print_r($request->all(),true));
            return response('ok');
        }

        if ($transaction->result != 'success') {
            $transaction->batch_id = $_REQUEST['intid'];
            $transaction->result = 'success';
            $transaction->source = '';
            $transaction->save();
            $commission = $transaction->amount * 0.01 * $transaction->commission;

            $transaction->wallet->refill(($transaction->amount - $commission), $transaction->source);
            $transaction->update(['approved' => true]);
            return response('ok');
        }

        \Log::info('FreeKassa hash is not passed. IP: ' . $request->ip());
        return response('ok');
    }
}
