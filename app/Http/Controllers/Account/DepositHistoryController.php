<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class DepositHistoryController
 * @package App\Http\Controllers\Account
 */
class DepositHistoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $deposits = auth()->user()->deposits()
            ->where('active', 0)
            ->paginate(50);

        return view('account.deposit_history', [
            'deposits'  => $deposits,
        ]);
    }
}
