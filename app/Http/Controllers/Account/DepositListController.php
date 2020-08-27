<?php
/**
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

/**
 * Class DepositListController
 * @package App\Http\Controllers\Account
 */
class DepositListController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $deposits = auth()->user()->deposits()
            ->where('active', 1)
            ->paginate(50);

        return view('account.deposit_list', [
            'deposits'  => $deposits,
        ]);
    }
}
