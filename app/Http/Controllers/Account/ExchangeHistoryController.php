<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionType;

/**
 * Class ExchangeHistoryController
 * @package App\Http\Controllers\Account
 */
class ExchangeHistoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $typeIn = TransactionType::getByName('exchange_in');
        $typeOut = TransactionType::getByName('exchange_out');

        /** @var Transaction $transactions */
        $transactions = auth()->user()->transactions()
            ->whereIn('type_id', [$typeIn->id, $typeOut->id])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('account.exchange_history', [
            'transactions' => $transactions,
        ]);
    }
}
