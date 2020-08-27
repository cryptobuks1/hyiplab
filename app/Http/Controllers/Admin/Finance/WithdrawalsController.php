<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class WithdrawalsController
 * @package App\Http\Controllers\Admin\Finance
 */
class WithdrawalsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $typeWithdrawal = TransactionType::getByName('withdraw');

        /** @var Transaction $transactions */
        $transactions = Transaction::where('type_id', $typeWithdrawal->id)
            ->where('approved', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.finance.withdrawals.index', [
            'transactions' => $transactions
        ]);
    }

    /**
     * @param string $id
     * @param bool $massMode
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|\Illuminate\Http\RedirectResponse|string|null
     * @throws \Exception
     */
    public static function approve(string $id)
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::find($id);

        if ($transaction->isApproved()) {
            return back()->with('error', __('this_application_already_processed'));
        }

        /** @var Wallet $wallet */
        $wallet         = $transaction->wallet()->first();
        /** @var User $user */
        $user           = $wallet->user()->first();
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem  = $wallet->paymentSystem()->first();
        /** @var Currency $currency */
        $currency       = $wallet->currency()->first();

        if (null === $wallet || null === $user || null === $paymentSystem || null === $currency) {
            throw new \Exception('Wallet, user, payment system or currency is not found for withdrawal approve.');
        }

        $ps = $paymentSystem->getClassInstance();

        if (empty($wallet->external)) {
            $msg = __('error_wallet_address_not_filled');
            $transaction->result = $msg;
            $transaction->save();

            return back()->with('error', $msg);
        }

        try {
            $batchId = $ps->transfer($transaction);
        } catch (\Exception $e) {
                $msg = __('ERROR:').' ' . $e->getMessage();

            $transaction->result = $msg;
            $transaction->save();

            return back()->with('error', $msg);
        }

        if (empty($batchId)) {
            $batchErr = __('error_batch_empty');

            $transaction->result = $batchErr;
            $transaction->save();

            return back()->with('error', __($batchErr));
        }

        $transaction->update([
            'batch_id' => $batchId,
            'approved' => true,
        ]);

        $user->sendEmailNotification('withdraw_confirmation', [], true);

        try {
            $ps->getBalances();
        } catch (\Exception $e) {
            return back()->with('error', __('ERROR:').' ' . $e->getMessage());
        }

        return back()->with('success', __('Order with amount').' '.$transaction->amount.$currency->symbol.' '.__('processed. funds sent.'));
    }

    /**
     * @param string $id
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|\Illuminate\Http\RedirectResponse|string|null
     * @throws \Exception
     */
    public function reject(string $id)
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::find($id);

        if ($transaction->isApproved()) {
            return back()->with('error', __('this_order_already_processed'));
        }

        /** @var Wallet $wallet */
        $wallet         = $transaction->wallet()->first();
        /** @var User $user */
        $user           = $wallet->user()->first();
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem  = $wallet->paymentSystem()->first();
        /** @var Currency $currency */
        $currency       = $wallet->currency()->first();
        $amount         = $transaction->amount;

        if (null === $wallet || null === $user || null === $paymentSystem || null === $currency) {
            throw new \Exception('Wallet, user, payment system or currency is not found for withdrawal reject.');
        }

        $wallet->returnFromRejectedWithdrawal($transaction);
        $transaction->delete();

        $user->sendEmailNotification('rejected_withdrawal', [], true);

        return back()->with('success', __('withdraw_cancelled_funds_returned'));
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function manually(string $id)
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::find($id);

        if ($transaction->isApproved()) {
            return back()->with('error', __('this_order_already_processed'));
        }

        /** @var Wallet $wallet */
        $wallet         = $transaction->wallet()->first();
        /** @var User $user */
        $user           = $wallet->user()->first();
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem  = $wallet->paymentSystem()->first();
        /** @var Currency $currency */
        $currency       = $wallet->currency()->first();

        if (null === $wallet || null === $user || null === $paymentSystem || null === $currency) {
            throw new \Exception('Wallet, user, payment system or currency is not found for withdrawal approve.');
        }

        if (empty($wallet->external)) {
            return back()->with('error', __('ERROR: wallet not filled'));
        }

        $transaction->update([
            'approved' => true
        ]);

        $user->sendEmailNotification('withdraw_confirmation', [], true);

        return back()->with('success', __('Order with amount').' '.$transaction->amount.$currency->symbol.' '.__('confirmed_in_fact_no_transfer'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
//    public function approveMany(Request $request)
//    {
//        $messages = [];
//
//        if ($request->approve) {
//            foreach ($request->list as $item) {
//                $messages[] = $this->approve($item, true);
//            }
//        } elseif ($request->approveManually) {
//            foreach ($request->list as $item) {
//                $messages[] = $this->approveManually($item, true);
//            }
//        } elseif ($request->reject) {
//            foreach ($request->list as $item) {
//                $messages[] = $this->reject($item, true);
//            }
//        }
//
//        return back()->with('success', __('List of withdrawal requests processed.').'<hr>'.implode('<hr>', $messages));
//    }
}
