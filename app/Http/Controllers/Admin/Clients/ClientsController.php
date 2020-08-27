<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Admin;
use App\Models\Currency;
use App\Models\Deposit;
use App\Models\PageViews;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class ClientsController
 * @package App\Http\Controllers\Admin
 */
class ClientsController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (!$request->has('search')) {
            /** @var User $users */
            $users = User::orderBy('created_at', 'desc')
                ->paginate(50);
        } else {
            /** @var User $users */
            $users = User::where(function($query) use($request) {
                $query->where('login', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('phone', 'like', '%'.$request->search.'%')
                    ->orWhere('skype', 'like', '%'.$request->search.'%')
                    ->orWhere('my_id', 'like', '%'.$request->search.'%');
            })
                ->orderBy('created_at', 'desc')
                ->paginate(50);
        }

        return view('admin.clients.index', [
            'users' => $users,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function show(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $pageViewsCount = PageViews::where('user_id', $user->id)->count();
        $logsCount      = ActionLog::where('user_id', $user->id)->count();
        $transactions   = $user->transactions()
            ->orderBy('created_at')
            ->paginate(10);
        /** @var Currency $mainCurrency */
        $mainCurrency   = Currency::where('main_currency', 1)->first();

        return view('admin.clients.show', [
            'user'             => $user,
            'pageViewsCount'   => $pageViewsCount,
            'logsCount'        => $logsCount,
            'transactions'     => $transactions,
            'mainCurrency'     => $mainCurrency,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function reftree(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $children = $this->getChildrens($user);

        return view('admin.clients.reftree', [
            'user'      => $user,
            'children'  => $children,
        ]);
    }

    /**
     * @param User $user
     */
    private function getChildrens(User $user)
    {
        if (empty($user)) {
            return [];
        }

        $referrals = [];
        $referrals['name'] = $user->login;
        $referrals['title'] = $user->email;

        if (!$user->hasReferrals()) {
            return $referrals;
        }

        foreach ($user->referrals()->wherePivot('line', 1)->get() as $r) {
            $referral = $this->getChildrens($r);
            $referrals['children'][] = $referral;
        }

        return $referrals;
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function edit(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        /** @var Deposit $deposits */
        $deposits       = $user->deposits()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.clients.edit', [
            'user'      => $user,
            'deposits'  => $deposits,
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function update(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->user['name'],
            'partner_id' => $request->user['partner_id'],
            'sex' => $request->user['sex'],
            'phone' => $request->user['phone'],
            'skype' => $request->user['skype'],
            'representative' => $request->user['representative'],
            'email_tester' => $request->user['email_tester'],
        ]);

        if ($request->user['email_verified_at'] && !$user->isVerifiedEmail()) {
            $user->email_verified_at = now()->toDateTimeString();
            $user->save();
        }

        if ($request->user['my_id'] != $user->my_id) {
            $checkExistsMyId = User::where('my_id', $request->user['my_id'])
                ->where('id', '!=', $user->id)
                ->count();

            if ($checkExistsMyId > 0) {
                session()->flash('error', __('this_ref_link_already_registered'));
                return back();
            }

            User::where('partner_id', $user->my_id)
                ->update([
                    'partner_id' => $request->user['my_id'],
                ]);

            $user->my_id = $request->user['my_id'];
            $user->save();
        }

        if ($request->user['login'] != $user->login) {
            $checkExistsLogin = User::where('login', $request->user['login'])
                ->where('id', '!=', $user->id)
                ->count();

            if ($checkExistsLogin > 0) {
                session()->flash('error', __('this_login_already_registered'));
                return back();
            }

            $user->login = $request->user['login'];
            $user->save();
        }

        if ($request->user['email'] != $user->email) {
            $checkExistsEmail = User::where('email', $request->user['email'])
                ->where('id', '!=', $user->id)
                ->count();

            if ($checkExistsEmail > 0) {
                session()->flash('error', __('this_email_already_registered'));
                return back();
            }

            $user->login = $request->user['login'];
            $user->save();
        }

        session()->flash('success', __('user_updated'));
        return back();
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function updatePassword(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        if (strlen($request->password) < 6) {
            session()->flash('error', __('password_must_be_at_least_6_chharacters'));
            return back();
        }

        if ($request->password != $request->password_confirm) {
            session()->flash('error', __('passwords_do_not_match'));
            return back();
        }

        $user->setPassword($request->password);

        return back()->with('success', __('password_changed'));
    }

    /**
     * @param string $walletId
     * @param Request $request
     */
    public function updateBalance(string $walletId, Request $request)
    {
        /** @var Wallet $wallet */
        $wallet = Wallet::findOrFail($walletId);

        $wallet->balance = (float) abs($request->balance);
        $wallet->save();

        return back()->with('success', __('wallet_balance').' '.$wallet->paymentSystem->name.' '.$wallet->currency->code.' '.__('successfully_updated.'));
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function block(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $user->blocked = 1;
        $user->save();

        return back()->with('success', __('user_blocked'));
    }

    /**
     * @param string $id
     * @param Request $request
     */
    public function unblock(string $id, Request $request)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $user->blocked = 0;
        $user->save();

        session()->flash('success', __('user_unblocked'));
        return back();
    }
}
