<?php
namespace App\Observers;

use App\Models\Deposit;
use App\Models\DepositQueue;
use App\Models\User;
use App\Models\Wallet;

/**
 * Class UserObserver
 * @package App\Observers
 */
class UserObserver
{
    /**
     * @param User $user
     * @throws \Exception
     */
    public function deleting(User $user) {
        foreach ($user->transactions()->get() as $transaction) {
            $transaction->delete();
        }

        /** @var Deposit $deposit */
        foreach ($user->deposits()->get() as $deposit) {
            DepositQueue::where('deposit_id', $deposit->id)->delete();
            $deposit->delete();
        }

        foreach ($user->wallets()->get() as $wallet) {
            $wallet->delete();
        }

        foreach ($user->mailSents()->get() as $mail) {
            $mail->delete();
        }

        foreach ($user->actionLogs()->get() as $item) {
            $item->delete();
        }

        User::where('partner_id', $user->my_id)->update([
            'partner_id' => null !== $user->partner_id
                ? $user->partner_id
                : null,
        ]);

        $user->partners()->detach();

        if (null !== $user->partner_id) {
            foreach ($user->referrals()->wherePivot('global', 0)->get() as $referral) {
                $referral->generatePartnerTree($user->partner);
            }
        }
    }

    /**
     * @param User $user
     * @return array
     */
    private function getCacheKeys(User $user): array
    {
        return [];
    }

    /**
     * @param User $user
     * @return array
     */
    private function getCacheTags(User $user): array
    {
        return [];
    }

    /**
     * Listen to the User created event.
     *
     * @param User $user
     * @return void
     * @throws
     */
    public function created(User $user)
    {
        Wallet::registerWallets($user);
        $user->sendVerificationEmail();

        clearCacheByArray($this->getCacheKeys($user));
        clearCacheByTags($this->getCacheTags($user));

        if (null!==$user->partner) {
            $user->generatePartnerTree($user->partner);
        }
    }

    /**
     * Listen to the User creating event.
     *
     * @param User $user
     * @return void
     * @throws
     */
    public function creating(User $user)
    {
        if (empty($user->login)) {
            $user->login = $user->email;
        }

        if (null === $user->my_id || empty($user->my_id)) {
            $user->my_id = generateMyId();
        }
    }

    /**
     * Listen to the User updated event.
     *
     * @param User $user
     * @return void
     * @throws
     */
    public function updated(User $user)
    {
        if ($user->isDirty(['email'])) {
            $user->refreshEmailVerificationAndSendNew();
        }

        if ($user->isDirty(['partner_id'])) {
            if ($user->partner_id == $user->my_id) {
                $user->partner_id = null;
                $user->save();
            }
        }
    }

    /**
     * Listen to the User saving event.
     *
     * @param User $user
     * @return void
     * @throws
     */
    public function saving(User $user)
    {
        //
    }

    /**
     * Listen to the User deleting event.
     *
     * @param User $user
     * @return void
     * @throws
     */
    public function deleted(User $user)
    {
        clearCacheByArray($this->getCacheKeys($user));
        clearCacheByTags($this->getCacheTags($user));
    }
}