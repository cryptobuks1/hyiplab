<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\PageViews;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class ClientLogsController
 * @package App\Http\Controllers\Admin\Clients
 */
class ClientLogsController extends AdminController
{
    /**
     * @param string $id
     * @param Request $request
     */
    public function index(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        /** @var ActionLog $logs */
        $logs = ActionLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.clients.logs.index', [
            'user'  => $user,
            'logs'  => $logs,
        ]);
    }
}