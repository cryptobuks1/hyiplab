<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestTransferFund;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class TransferFundController
 * @package App\Http\Controllers\Account
 */
class TransferFundController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.transfer_fund');
    }

    /**
     * @param RequestTransferFund $request
     */
    public function handle(RequestTransferFund $request)
    {
        /** @var Wallet $walletFrom */
        $walletFrom = auth()->user()->wallets()
            ->where('id', $request->wallet_from_id)
            ->first();

        if (null == $walletFrom) {
            session()->flash('error', __('send_wallet_not_found'));
            return back();
        }

        /** @var User $addressee */
        $addressee = User::where(function($query) use($request) {
            $query->where('login', trim($request->addressee))
                ->orWhere('email', trim($request->addressee));
        })->where('id', '!=', auth()->user()->id)->first();

        if (null == $addressee) {
            session()->flash('error', __('recipient_not_found'));
            return back();
        }

        /** @var Wallet $walletTo */
        $walletTo = $addressee->wallets()
            ->where('currency_id', $walletFrom->currency_id)
            ->where('payment_system_id', $walletFrom->payment_system_id)
            ->first();

        if (null == $walletTo) {
            /** @var Wallet $walletTo */
            $walletTo = Wallet::newWallet($addressee, $walletFrom->currency, $walletFrom->paymentSystem);
        }

        if (null == $walletTo) {
            session()->flash('error', __('recipient_wallet_not_found'));
            return back();
        }

        /** @var float $amount */
        $amount = (float) abs($request->amount);

        if ($walletFrom->balance < $amount) {
            session()->flash('error', __('insufficient_funds_to_send'));
            return back();
        }

        $walletFrom->balance -= $amount;
        $walletFrom->save();

        $walletTo->balance += $amount;
        $walletTo->save();

        Transaction::transferOut($walletFrom, $amount);
        Transaction::transferIn($walletTo, $amount);

        session()->flash('success', $amount.$walletFrom->currency->symbol.' '.__('sent_to_user').' '.$addressee->email.' ('.__('login:').' '.$addressee->login.')');
        return back();
    }
}
