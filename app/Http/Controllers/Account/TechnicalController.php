<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * Class TechnicalController
 * @package App\Http\Controllers\Account
 */
class TechnicalController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function getExchangeRateByWallet(Request $request)
    {
        if (!$request->has('from') || !$request->has('to')) {
            return response()->json(['rate' => 0, 'message' => __('incorrect_data'), 'error' => 1]);
        }

        /** @var Wallet $walletFrom */
        $walletFrom = auth()->user()->wallets()->where('id', $request->from)->first();

        /** @var Wallet $walletTo */
        $walletTo = auth()->user()->wallets()->where('id', $request->to)->first();

        if ($walletFrom->id == $walletTo->id) {
            return response()->json(['rate' => 0, 'message' => __('wallets_must_be_different'), 'error' => 1]);
        }

        if ($walletFrom->currency_id == $walletTo->currency_id) {
            return response()->json(['rate' => 1, 'message' => __('exchange_for_same_currency')]);
        }

        $rate = Setting::getValue(strtolower($walletFrom->currency->code).'_to_'.strtolower($walletTo->currency->code), 0);

        if ($rate > 0) {
            return response()->json(['rate' => $rate, 'message' => __('found_exchange_rate')]);
        } else {
            return response()->json(['rate' => 0, 'message' => __('exchange_rate_not_found'), 'error' => 1]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserExistsByEmailOrLogin(Request $request)
    {
        if (!$request->has('data')) {
            return response()->json(['message' => __('incorrect_data'), 'error' => 1]);
        }

        /** @var integer $checkUserExists */
        $checkUserExists = User::where(function($query) use($request) {
            $query->where('login', trim($request->data))
                ->orWhere('email', trim($request->data));
        })->where('id', '!=', auth()->user()->id)->count();

        if ($checkUserExists <= 0) {
            return response()->json(['message' => __('recipient_not_found'), 'error' => 1]);
        }

        return response()->json(['message' => __('recipient_not_found'), 'error' => 0]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reftree(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $children = $this->getChildrens($user);

        return view('account.technical.reftree', [
            'user'      => $user,
            'children'  => $children,
        ]);
    }

    /**
     * @param User $user
     * @return array
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
}
