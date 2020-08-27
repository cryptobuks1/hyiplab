<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

/**
 * Class TransactionsController
 * @package App\Http\Controllers\Account
 */
class TransactionsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var Transaction $transactions */
        $transactions = auth()->user()->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('account.transactions', [
            'transactions' => $transactions,
        ]);
    }
}
