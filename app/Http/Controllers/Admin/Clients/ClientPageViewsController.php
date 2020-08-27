<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\PageViews;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class ClientPageViewsController
 * @package App\Http\Controllers\Admin\Clients
 */
class ClientPageViewsController extends AdminController
{
    /**
     * @param string $id
     * @param Request $request
     */
    public function index(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        /** @var PageViews $pageViews */
        $pageViews = PageViews::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.clients.page_views.index', [
            'user'       => $user,
            'pageViews'  => $pageViews,
        ]);
    }
}