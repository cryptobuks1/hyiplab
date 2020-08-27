<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\SysLoad;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class StatisticController
 * @package App\Http\Controllers\Admin\Finance
 */
class StatisticController extends AdminController
{
    public function index(Request $request)
    {
        /**
         * SERVER LOAD
         */
        $serverLoadLastWeek = [];

        for($i=6; $i>=0; $i--) {
            $averageCpu = SysLoad::where('created_at', 'like', now()->subDays($i)->toDateString().'%')->avg('cpu');
            $averageRam = SysLoad::where('created_at', 'like', now()->subDays($i)->toDateString().'%')->avg('ram');

            $serverLoadLastWeek['cpu'][now()->subDays($i)->toDateString()] = $averageCpu ?? 0;
            $serverLoadLastWeek['ram'][now()->subDays($i)->toDateString()] = $averageRam ?? 0;
            $serverLoadLastWeek['dates'][] = now()->subDays($i)->toDateString();
        }

        /**
         * USERS STATISTIC
         */
        $popularUsers = \DB::table('user_parents')
            ->select(\DB::raw('count(*) as user_count, parent_id'))
            ->where('line', 1)
            ->groupBy('parent_id')
            ->orderBy('user_count', 'desc')
            ->limit(10)
            ->get();

        foreach ($popularUsers as $key => $user) {
            $popularUsers[$key]->parent = User::find($user->parent_id);
            $popularUsers[$key]->last_ref = $popularUsers[$key]
                ->parent
                ->referrals()
                ->select('created_at')
                ->wherePivot('line', 1)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->first();
        }

        return view('admin.finance.statistic.index', [
            'serverLoadLastWeek'    => $serverLoadLastWeek,
            'popularUsers'          => $popularUsers,
        ]);
    }
}
