<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Http\Request;

/**
 * Class PendingHistoryController
 * @package App\Http\Controllers\Account
 */
class PendingHistoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $typeWithdraw = TransactionType::getByName('withdraw');

        /** @var Transaction $transactions */
        $transactions = auth()->user()->transactions()
            ->where('type_id', $typeWithdraw->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('account.pending_history', [
            'transactions' => $transactions,
        ]);
    }
}
