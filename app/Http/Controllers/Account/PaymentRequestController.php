<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestWithdraw;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class PaymentRequestController
 * @package App\Http\Controllers\Account
 */
class PaymentRequestController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('account.payment_request');
    }

    /**
     * @param RequestWithdraw $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(RequestWithdraw $request)
    {
        /** @var Wallet $wallet */
        $wallet = auth()->user()->wallets()->find($request->wallet_id);

        $amount = (float) abs($request->amount);

        if ($wallet->balance - $wallet->balance * TransactionType::getByName('withdraw')->commission * 0.01 < $amount) {
            return back()->with('error', __('requested_amount_greater_than_balance'));
        }

        if ($wallet->external != $request->external && !empty($request->external)) {
            $wallet->external = trim($request->external);
            $wallet->save();
        }

        if (empty($wallet->external)) {
            return back()->with('error', __('enter_your_wallet_address'));
        }

        try {
            Transaction::withdraw($wallet, $amount);
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('application_accepted'));
    }
}
