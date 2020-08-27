<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\MailSent;
use App\Models\Rate;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var Currency $currencies */
        $currencies = Currency::get();

        $withdrawType = TransactionType::getByName('withdraw');

        $totalInvestedArr       = [];
        $totalWithdrewArr       = [];
        $differentInvested24H   = 0;

        /** @var Currency $currency */
        foreach ($currencies as $currency) {
            $totalInvestedArr[$currency->code] = Deposit::where('currency_id', $currency->id)
                ->sum('invested');

            $totalWithdrewArr[$currency->code] = Transaction::where('currency_id', $currency->id)
                ->where('type_id', $withdrawType->id)
                ->where('approved', 1)
                ->sum('amount');

            $pastInvested = Deposit::where('currency_id', $currency->id)
                ->where('created_at', '>=', now()->subHours(48)->toDateTimeString())
                ->where('created_at', '<=', now()->subHours(24)->toDateTimeString())
                ->sum('invested');
            $todayInvested = Deposit::where('currency_id', $currency->id)
                ->where('created_at', '>=', now()->subHours(24)->toDateTimeString())
                ->sum('invested');

            if ($pastInvested > 0) {
                $divide = $differentInvested24H > 0;
                $differentInvested24H += round((1 - $todayInvested / $pastInvested) * 100, 1);

                if ($divide == true) {
                    $differentInvested24H /= 2;
                }
            }
        }

        $usersCount         = User::count();
        $depositsCount      = Deposit::count();
        $mailsCount         = MailSent::count();
        $transactionsCount  = Transaction::count();

        $createDepositType          = TransactionType::getByName('create_dep');
        $thisWeekInvestments        = Transaction::where('type_id', $createDepositType->id)
            ->where('created_at', '>=', now()->subDays(7)->toDateTimeString())
            ->where('created_at', '<=', now()->toDateTimeString())
            ->sum('main_currency_amount');
        $previousWeekInvestments    = Transaction::where('type_id', $createDepositType->id)
            ->where('created_at', '>=', now()->subDays(14)->toDateTimeString())
            ->where('created_at', '<=', now()->subDays(7)->toDateTimeString())
            ->sum('main_currency_amount');

        /** @var Currency $mainCurrency */
        $mainCurrency = Currency::where('main_currency', 1)->first();

        $investmentChartData = [];

        for ($i=1; $i <= 7; $i++) {
            $thisWeekDayInvestments         = amountWithPrecision(Transaction::where('type_id', $createDepositType->id)
                ->where('created_at', '>=', now()->subDays($i)->startOfDay()->toDateTimeString())
                ->where('created_at', '<=', now()->subDays($i)->endOfDay()->toDateTimeString())
                ->sum('main_currency_amount'), $mainCurrency);
            $previousWeekDayInvestments     = amountWithPrecision(Transaction::where('type_id', $createDepositType->id)
                ->where('created_at', '>=', now()->subDays($i)->subWeek()->startOfDay()->toDateTimeString())
                ->where('created_at', '<=', now()->subDays($i)->subWeek()->endOfDay()->toDateTimeString())
                ->sum('main_currency_amount'), $mainCurrency);

            $investmentChartData['this_week'][$i]           = $thisWeekDayInvestments;
            $investmentChartData['previous_week'][$i]       = $previousWeekDayInvestments;
            $investmentChartData['this_week_datetime'][$i]  = now()->subDays($i)->endOfDay()->toIso8601String();
        }

        $totalWithdrew = Transaction::where('type_id', $withdrawType->id)
            ->where('approved', true)
            ->sum('main_currency_amount');

        $withdrawChartData = [];

        for ($i=1; $i <= 7; $i++) {
            $thisWeekDayWithdrew = amountWithPrecision(\App\Models\Transaction::where('type_id', $withdrawType->id)
                ->where('created_at', '>=', now()->subDays($i)->startOfDay()->toDateTimeString())
                ->where('created_at', '<=', now()->subDays($i)->endOfDay()->toDateTimeString())
                ->where('approved', 1)
                ->sum('main_currency_amount'), $mainCurrency);

            $withdrawChartData['this_week'][$i] = $thisWeekDayWithdrew;
            $withdrawChartData['this_week_datetime'][$i] = now()->subDays($i)->endOfDay()->toIso8601String();
        }

        $typeTopup = TransactionType::getByName('enter');
        $allTimeEnterSum    = Transaction::where('type_id', $typeTopup->id)
            ->where('approved', 1)
            ->sum('main_currency_amount');
        $allTimeWithdrawSum = Transaction::where('type_id', $withdrawType->id)
            ->where('approved', 1)
            ->sum('main_currency_amount');

        $allTimeEnterPercent    = 50;
        $allTimeWithdrawPercent = 50;

        if ($allTimeEnterSum > 0 && $allTimeWithdrawSum > 0) {
            $allTimeEnterPercent = self::percentDifferent($allTimeEnterSum, $allTimeWithdrawSum);
            $allTimeWithdrawPercent = 100 - $allTimeEnterPercent;
        } elseif($allTimeEnterSum > 0) {
            $allTimeEnterPercent = 100;
        } elseif($allTimeWithdrawSum > 0) {
            $allTimeWithdrawPercent = 100;
        }

        /** @var User $latestUsers */
        $latestUsers = User::with(['partner'])
            ->orderBy('created_at', 'desc')
            ->limit(10);

        /** @var Deposit $latestDeposits */
        $latestDeposits = Deposit::orderBy('created_at', 'desc')
            ->limit(10);

        /** @var ActionLog $adminLogs */
        $adminLogs = ActionLog::where('is_admin', 1)
            ->orderBy('created_at', 'desc')
            ->limit(20);

        $ratesStat = [];
        $typeCreateDep = TransactionType::getByName('create_dep');

        for($i=6; $i>=0; $i--) {
            $ratesStat['dates'][] = now()->subDays($i)->toDateString();
        }

        /** @var Rate $rate */
        foreach (Rate::orderBy('min')->get() as $rate) {
            $ratesStat['rates'][$rate->id]['rate'] = $rate;

            for($i=6; $i>=0; $i--) {
                $sumInvestments = Transaction::where('type_id', $typeCreateDep->id)
                    ->where('rate_id', $rate->id)
                    ->where('approved', 1)
                    ->where('created_at', 'like', now()->subDays($i)->toDateString() . '%')
                    ->sum('main_currency_amount');

                $ratesStat['rates'][$rate->id]['days'][] = $sumInvestments;
            }
        }

        return view('admin.dashboard', [
            'currencies'                => $currencies,
            'totalInvestedArr'          => $totalInvestedArr,
            'differentInvested24H'      => $differentInvested24H,
            'usersCount'                => $usersCount,
            'depositsCount'             => $depositsCount,
            'mailsCount'                => $mailsCount,
            'transactionsCount'         => $transactionsCount,
            'thisWeekInvestments'       => $thisWeekInvestments,
            'previousWeekInvestments'   => $previousWeekInvestments,
            'mainCurrency'              => $mainCurrency,
            'investmentChartData'       => $investmentChartData,
            'totalWithdrew'             => $totalWithdrew,
            'withdrawChartData'         => $withdrawChartData,
            'allTimeEnterPercent'       => $allTimeEnterPercent,
            'allTimeWithdrawPercent'    => $allTimeWithdrawPercent,
            'latestUsers'               => $latestUsers,
            'latestDeposits'            => $latestDeposits,
            'totalWithdrewArr'          => $totalWithdrewArr,
            'adminLogs'                 => $adminLogs,
            'ratesStat'                 => $ratesStat,
        ]);
    }

    /**
     * @param $a
     * @param $b
     * @return float|int
     */
    public static function percentDifferent($a, $b) {
        return round((($a-$b)/$a)*100);
    }
}
