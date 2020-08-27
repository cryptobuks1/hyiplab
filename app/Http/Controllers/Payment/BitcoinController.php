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
use App\Modules\PaymentSystems\BitcoinModule;
use Illuminate\Support\Facades\Auth;

/**
 * Class BitcoinController
 * @package App\Http\Controllers\Payment
 */
class BitcoinController extends PaymentController
{
    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
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

        if (!$wallet) {
            $wallet = Wallet::newWallet($user, $currency, $paymentSystem);
        }

        /** @var Transaction $transaction */
        $transaction = Transaction::enter($wallet, $amount);

        try {
            $bitcoin = new BitcoinModule();
            $getnewaddress = $bitcoin->getnewaddress();
        } catch (\Exception $e) {
            \Log::error('Can not create bitcoin wallet: '.$e->getMessage());
            return response('Error. Try again later.');
        }

        if (empty($getnewaddress)) {
            return response('Error. Try again later..');
        }

        $transaction->source = $getnewaddress;
        $transaction->save();

        return view('ps.bitcoin', [
            'currency' => $currency,
            'amount' => $amount,
            'user' => $user,
            'transaction' => $transaction,
            'paymentSystem' => $paymentSystem,
            'commission' => $transaction->type->commission * 0.01 * $amount,
        ]);

    }
}
