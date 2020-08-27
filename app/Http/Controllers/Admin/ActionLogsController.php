<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Http\Request;

/**
 * Class ActionLogsController
 * @package App\Http\Controllers\Admin
 */
class ActionLogsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        /** @var ActionLog $adminLogs */
        $adminLogs = ActionLog::where('is_admin', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.action_logs.index', [
            'adminLogs' => $adminLogs,
        ]);
    }
}
