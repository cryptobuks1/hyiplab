<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\TransactionType;
use Illuminate\Http\Request;

/**
 * Class MyAccountController
 * @package App\Http\Controllers\Account
 */
class MyAccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $typeCreateDep = TransactionType::getByName('create_dep');
        $typeWithdraw = TransactionType::getByName('withdraw');
        $typeDividend = TransactionType::getByName('dividend');
        $typeReferral = TransactionType::getByName('partner');

        $activeDeposits = auth()
            ->user()
            ->transactions()
            ->whereHas('deposit', function($query) {
                $query->where('active', 1);
            })
            ->where('type_id', $typeCreateDep->id)
            ->sum('amount');

        $closedDeposits = auth()
            ->user()
            ->transactions()
            ->whereHas('deposit', function($query) {
                $query->where('active', 0);
            })
            ->where('type_id', $typeCreateDep->id)
            ->sum('amount');

        $pendingWithdrawals = auth()
            ->user()
            ->transactions()
            ->where('approved', 0)
            ->where('type_id', $typeWithdraw->id)
            ->sum('amount');

        $successWithdrawals = auth()
            ->user()
            ->transactions()
            ->where('approved', 0)
            ->where('type_id', $typeWithdraw->id)
            ->sum('amount');

        $todayEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeDividend->id)
            ->where('created_at', '>=', now()->subHours(24)->toDateTimeString())
            ->sum('amount');

        $thisWeekEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeDividend->id)
            ->where('created_at', '>=', now()->subWeeks(1)->toDateTimeString())
            ->sum('amount');

        $thisMonthEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeDividend->id)
            ->where('created_at', '>=', now()->subMonths(1)->toDateTimeString())
            ->sum('amount');

        $totalEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeDividend->id)
            ->sum('amount');

        $todayReferrals = auth()
            ->user()
            ->referrals()
            ->where('created_at', '>=', now()->subHours(24)->toDateTimeString())
            ->count();

        $thisWeekReferrals = auth()
            ->user()
            ->referrals()
            ->where('created_at', '>=', now()->subWeeks(1)->toDateTimeString())
            ->count();

        $totalReferrals = auth()
            ->user()
            ->referrals()
            ->count();

        $todayReferralsEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeReferral->id)
            ->where('created_at', '>=', now()->subMonths(1)->toDateTimeString())
            ->sum('amount');

        $thisWeekReferralsEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeReferral->id)
            ->where('created_at', '>=', now()->subWeeks(1)->toDateTimeString())
            ->sum('amount');

        $totalReferralsEarnings = auth()
            ->user()
            ->transactions()
            ->where('approved', 1)
            ->where('type_id', $typeReferral->id)
            ->sum('amount');

        $transactions = auth()
            ->user()
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('account.my_account', [
            'activeDeposits'            => $activeDeposits,
            'closedDeposits'            => $closedDeposits,
            'pendingWithdrawals'        => $pendingWithdrawals,
            'successWithdrawals'        => $successWithdrawals,
            'todayEarnings'             => $todayEarnings,
            'thisWeekEarnings'          => $thisWeekEarnings,
            'thisMonthEarnings'         => $thisMonthEarnings,
            'totalEarnings'             => $totalEarnings,
            'todayReferrals'            => $todayReferrals,
            'thisWeekReferrals'         => $thisWeekReferrals,
            'totalReferrals'            => $totalReferrals,
            'todayReferralsEarnings'    => $todayReferralsEarnings,
            'thisWeekReferralsEarnings' => $thisWeekReferralsEarnings,
            'totalReferralsEarnings'    => $totalReferralsEarnings,
            'transactions'              => $transactions,
        ]);
    }
}
