<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\ActionLog;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

/**
 * Class AdministratorsController
 * @package App\Http\Controllers\Admin\Settings
 */
class AdministratorsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!$request->has('search')) {
            /** @var Admin $admins */
            $admins = Admin::orderBy('created_at', 'desc')
                ->paginate(50);
        } else {
            /** @var Admin $admins */
            $admins = Admin::where(function($query) use($request) {
                $query->where('login', 'like', '%'.$request->search.'%')
                    ->orWhere('name', 'like', '%'.$request->search.'%');
            })
                ->orderBy('created_at', 'desc')
                ->paginate(50);
        }

        return view('admin.settings.administrators.index', [
            'admins' => $admins,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);

        /** @var ActionLog $actionLogs */
        $actionLogs = $admin->actionLogs()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.settings.administrators.show', [
            'admin'         => $admin,
            'actionLogs'    => $actionLogs,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        /** @var Permission $permissions */
        $permissions = Permission::all();

        return view('admin.settings.administrators.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function update(string $id, Request $request)
    {
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);

        $admin->update([
            'name'          => $request->admin['name'],
            'created_at'    => Carbon::parse($request->admin['created_at'])->format('Y-m-d H:i:s'),
        ]);

        if ($request->admin['login'] != $admin->login) {
            $checkExistsLogin = Admin::where('login', $request->admin['login'])
                ->where('id', '!=', $admin->id)
                ->count();

            if ($checkExistsLogin > 0) {
                session()->flash('error', __('this_login_already_registered'));
                return back();
            }

            $admin->login = $request->admin['login'];
            $admin->save();
        }

        $admin->syncPermissions($request->permissions);

        session()->flash('success', __('admin_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function store(Request $request)
    {
        /** @var Admin $admin */
        $admin = new Admin();

        $admin->name = $request->admin['name'];
        $admin->created_at = $request->admin['created_at'];

        $checkExistsLogin = Admin::where('login', $request->admin['login'])
            ->count();

        if ($checkExistsLogin > 0) {
            session()->flash('error', __('this_login_already_registered'));
            return back();
        }

        if ($request->password != $request->password_confirm) {
            session()->flash('error', __('passwords_do_not_match'));
            return back();
        }

        $admin->setPassword($request->password);

        $admin->login = $request->admin['login'];
        $admin->save();

        $admin->syncPermissions($request->permissions);

        session()->flash('success', __('admin_registered'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id, Request $request)
    {
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);

        if ($admin->id == admin()->id) {
            session()->flash('error', __('you_cannot_delete_yourself'));
            return back();
        }

        $admin->delete();

        session()->flash('success', __('admin_deleted'));
        return redirect()->route('admin.settings.administrators.index');
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function updatePassword(string $id, Request $request)
    {
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);

        if ($request->password != $request->password_confirm) {
            session()->flash('error', __('password_do_not_match_try_again'));
            return back();
        }

        $admin->setPassword($request->password);

        return back()->with('success', __('password_changed'));
    }
}
