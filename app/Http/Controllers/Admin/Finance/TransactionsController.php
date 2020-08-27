<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class TransactionsController
 * @package App\Http\Controllers\Admin\Finance
 */
class TransactionsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!$request->has('search')) {
            /** @var Transaction $transactions */
            $transactions = Transaction::orderBy('created_at', 'desc')
                ->paginate(50);
        } else {
            /** @var Transaction $transactions */
            $transactions = Transaction::where(function($query) use($request) {
                $query->where('id', 'like', '%'.$request->search.'%')
                    ->orWhere('batch_id', 'like', '%'.$request->search.'%')
                    ->orWhere('result', 'like', '%'.$request->search.'%');
            })
                ->orderBy('created_at', 'desc')
                ->paginate(50);
        }

        return view('admin.finance.transactions.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $id, Request $request)
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::findOrFail($id);

        return view('admin.finance.transactions.show', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, Request $request)
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::findOrFail($id);

        $data = $request->all('transaction');
        $data = $data['transaction'];
        $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');
        $data['approved'] = isset($data['approved']) && $data['approved'] == 1 ? 1 : 0;

        $transaction->update($data);

        session()->flash('success', __('transaction_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id, Request $request)
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        session()->flash('success', __('transaction_deleted'));
        return redirect()->route('admin.finance.transactions.index');
    }
}
