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
 * Class ReferralEarningsController
 * @package App\Http\Controllers\Account
 */
class ReferralEarningsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $typePartner = TransactionType::getByName('partner');

        /** @var Transaction $transactions */
        $transactions = auth()->user()->transactions()
            ->where('type_id', $typePartner->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('account.referral_earnings', [
            'transactions' => $transactions,
        ]);
    }
}
