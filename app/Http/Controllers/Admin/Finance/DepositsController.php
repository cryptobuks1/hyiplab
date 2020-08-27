<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class DepositsController
 * @package App\Http\Controllers\Admin\Finance
 */
class DepositsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $deposits = Deposit::where(null);

        if ($request->has('searchByRate') && !empty($request->searchByRate)) {
            $deposits->where('rate_id', $request->searchByRate);
        }

        if ($request->has('searchByUser') && !empty($request->searchByUser)) {
            $deposits->where('user_id', $request->searchByUser);
        }

        $deposits = $deposits->paginate(50);

        return view('admin.finance.deposits.index', [
            'deposits'  => $deposits,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Deposit $deposit */
        $deposit = Deposit::findOrFail($id);

        $queues = $deposit->queues()
            ->orderBy('available_at')
            ->paginate(20);

        return view('admin.finance.deposits.show', [
            'deposit'   => $deposit,
            'queues'    => $queues,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Deposit $deposit */
        $deposit = Deposit::findOrFail($id);

        $data = $request->all('deposit');
        $data = $data['deposit'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');
        $data['active'] = isset($data['active']) && $data['active'] == 1 ? 1 : 0;

        $deposit->update($data);

        session()->flash('success', __('deposit_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id, Request $request)
    {
        /** @var Deposit $deposit */
        $deposit = Deposit::findOrFail($id);
        $deposit->delete();

        session()->flash('success', __('deposit_deleted'));
        return redirect()->route('admin.finance.deposits.index');
    }
}
