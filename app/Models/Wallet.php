<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * @package App\Models
 *
 * @property string id
 * @property string user_id
 * @property string currency_id
 * @property string payment_system_id
 * @property string external
 * @property float balance
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Currency currency
 * @property PaymentSystem paymentSystem
 * @property Transaction transactions
 * @property User user
 * @property Deposit deposits
 */
class Wallet extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'user_id',
        'currency_id',
        'payment_system_id',
        'external',
        'balance',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'wallet_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'wallet_id');
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function addBonus($amount)
    {
        $this->update([
            'balance' => $this->balance + $amount
        ]);
        Transaction::bonus($this, $amount);

        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function removeAmount($amount)
    {
        $this->update([
            'balance' => $this->balance - $amount
        ]);

        return $this;
    }

    /**
     * @param float $amount
     * @return bool
     */
    public function addAmountWithoutAccrueToPartner($amount=0.00)
    {
        $this->update([
            'balance' => $this->balance + $amount
        ]);

        return true;
    }

    /**
     * @param float $amount
     * @param string $partnerAccrueType
     * @return int
     * @throws \Throwable
     */
    public function addAmountWithAccrueToPartner($amount=0.00, $partnerAccrueType='deposit')
    {
        $this->update([
            'balance' => $this->balance + $amount
        ]);

        return $this->accrueToPartner($amount, $partnerAccrueType);
    }

    /**
     * @param User $user
     * @param Currency $currency
     * @param PaymentSystem $paymentSystem
     * @return Wallet|null
     */
    public static function newWallet(User $user, Currency $currency, PaymentSystem $paymentSystem)
    {
        $checkExists = $user->wallets()->where('currency_id', $currency->id)
            ->where('payment_system_id', $paymentSystem->id)
            ->first();

        if (null !== $checkExists) {
            return null;
        }

        return self::create([
            'user_id'           => $user->id,
            'currency_id'       => $currency->id,
            'payment_system_id' => $paymentSystem->id,
        ]);

    }

    /**
     * @param float $amount
     * @param string|null $external
     * @throws \Throwable
     */
    public function refill($amount, $external=null)
    {
        $this->balance += $amount;

        if (!empty($external)) {
            $this->external = $external;
        }

        $this->save();
        $this->accrueToPartner($amount, 'refill');
        
        return true;
    }

    /**
     * @param Transaction $transaction
     */
    public function returnFromRejectedWithdrawal(Transaction $transaction)
    {
        $this->update([
            'balance' => $this->balance + $transaction->amount
        ]);
    }

    /**
     * @param $amount
     * @param $type
     * @return int
     * @throws \Throwable
     */
    public function accrueToPartner($amount, $type)
    {
        /** @var User $user */
        $user           = $this->user;
        $partnerLevels  = $user->getPartnerLevels();

        if (!$partnerLevels) {
            return 0;
        }

        foreach ($partnerLevels as $level) {
            /** @var User $partner */
            $partner = $user->getPartnerOnLevel($level);

            if (empty($partner)) {
                continue;
            }

            $percent = 0;

            if (!$partner->isRepresentative()) {
                if ($type == 'refill') {
                    $percent = Referral::getOnLoad($level);
                } elseif ($type == 'deposit') {
                    $percent = Referral::getOnProfit($level);
                }
            } else {
                /*
                 * TODO: нужно прораьотать репрезентативные проценты, думаю нужно хранить в таблице юзеров.
                 */
                if ($type == 'refill') {
                    $percent = Referral::getOnLoad($level);
                } elseif ($type == 'deposit') {
                    $percent = Referral::getOnProfit($level);
                }
            }

            if ($percent <= 0) {
                continue;
            }

            $partnerAmount  = $amount * $percent / 100;
            $partnerWallet = $partner->wallets()
                ->where('payment_system_id', $this->payment_system_id)
                ->where('currency_id', $this->currency_id)
                ->first();

            if (null == $partnerWallet) {
                /** @var Wallet $partnerWallet */
                $partnerWallet = self::newWallet($partner, $this->currency, $this->paymentSystem);
            }

            $summaryAmount = 0;
            $partnerWallet->referralRefill($partnerAmount, $this, $type, $level);
            $summaryAmount += $partnerAmount;
        }

        return isset($summaryAmount)
            ? $summaryAmount
            : 0;
    }

    /**
     * @param $amount
     * @param $referral
     * @param $type
     * @param int $level
     * @return Transaction|null
     */
    public function referralRefill($amount, $referral, $type, $level=0)
    {
        $refUser = $this->user;

        if ($refUser !== null) {
            \Log::error('refback user found '.$refUser->id);

            if ($refUser->refback > 0) {
                $refback = (float) $refUser->refback;
                $refbackAmount = $amount / 100 * $refback;
                $amount -= $refbackAmount;

                $referral->refill($refbackAmount, '', true);
                Transaction::refback($referral, $refbackAmount);

                \Log::error('found refback ' . $refUser->refback . ', amount ' . $refbackAmount);
            }
        }

        if ($amount <= 0) {
            return null;
        }

        $this->update([
            'balance' => $this->balance + $amount
        ]);

        if ($type == 'refill') {
            return Transaction::partner($this, $amount, $referral);
        } elseif ($type == 'deposit') {
            return Transaction::partner($this, $amount, $referral);
        }
    }

    /**
     * @param User $user
     */
    public static function registerWallets(User $user)
    {
        $paymentSystems = PaymentSystem::with([
            'currencies'
        ])->get();

        /** @var PaymentSystem $paymentSystem */
        foreach ($paymentSystems as $paymentSystem) {
            /** @var Currency $currency */
            foreach ($paymentSystem->currencies as $currency) {
                $checkExists = $user->wallets()
                    ->where('payment_system_id', $paymentSystem->id)
                    ->where('currency_id', $currency->id)
                    ->get()
                    ->count();

                if ($checkExists > 0) {
                    continue;
                }

                self::newWallet($user, $currency, $paymentSystem);
            }
        }
    }
}
