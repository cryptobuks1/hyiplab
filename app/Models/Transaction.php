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
 * Class Transaction
 * @package App\Models
 *
 * @property string id
 * @property string type_id
 * @property string user_id
 * @property string rate_id
 * @property string deposit_id
 * @property string wallet_id
 * @property string payment_system_id
 * @property float amount
 * @property float main_currency_amount
 * @property string source
 * @property string result
 * @property string batch_id
 * @property bool approved
 * @property float commission
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Wallet wallet
 * @property Rate rate
 * @property Deposit deposit
 * @property Currency currency
 * @property PaymentSystem paymentSystem
 * @property TransactionType type
 * @property User user
 */
class Transaction extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'type_id',
        'user_id',
        'currency_id',
        'rate_id',
        'deposit_id',
        'wallet_id',
        'payment_system_id',
        'amount',
        'main_currency_amount',
        'source',
        'result',
        'batch_id',
        'approved',
        'commission',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rate()
    {
        return $this->belongsTo(Rate::class, 'rate_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentSystem()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @param $wallet
     * @param $amount
     * @return mixed
     */
    public static function enter($wallet, $amount)
    {
        $type = TransactionType::getByName('enter');

        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @return Transaction|null
     * @throws \Exception
     */
    public static function withdraw(Wallet $wallet, float $amount)
    {
        $amount = (float) abs($amount);
        $type   = TransactionType::getByName('withdraw');

        /** @var User $user */
        $user = $wallet->user;

        /** @var Currency $currency */
        $currency = $wallet->currency;

        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = $wallet->paymentSystem;

        if (null === $type || null === $user || null === $currency || null === $paymentSystem) {
            return null;
        }

        $commission           = $type->commission;
        $amountWithCommission = $amount / ((100 - $commission) * 0.01);

        $psMinimumWithdrawArray = @json_decode($paymentSystem->minimum_withdraw, true);
        $psMinimumWithdraw      = isset($psMinimumWithdrawArray[$currency->code])
            ? $psMinimumWithdrawArray[$currency->code]
            : 0;

        if ($amount+$commission < $psMinimumWithdraw) {
            throw new \Exception(__('Minimum withdraw amount is ').$psMinimumWithdraw.$currency->symbol);
        }

        $wallet->update([
            'balance' => $wallet->balance - $amountWithCommission
        ]);

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $commission,
            'user_id'           => $user->id,
            'currency_id'       => $currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $paymentSystem->id,
            'amount'            => $amountWithCommission,
            'approved'          => false,
        ]);

        $transaction->user->sendEmailNotification('withdraw_order', ['transaction' => $transaction], true);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param $wallet
     * @param $amount
     * @return Transaction|null
     */
    public static function bonus($wallet, $amount)
    {
        $type = TransactionType::getByName('bonus');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @return Transaction|null
     */
    public static function exchangeOut(Wallet $wallet, float $amount)
    {
        $type = TransactionType::getByName('exchange_out');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @return Transaction|null
     */
    public static function exchangeIn(Wallet $wallet, float $amount)
    {
        $type = TransactionType::getByName('exchange_in');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @return Transaction|null
     */
    public static function transferOut(Wallet $wallet, float $amount)
    {
        $type = TransactionType::getByName('transfer_out');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @return Transaction|null
     */
    public static function transferIn(Wallet $wallet, float $amount)
    {
        $type = TransactionType::getByName('transfer_in');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        $wallet->user->sendEmailNotification('transfer_in', [
            'transaction' => $transaction,
        ], true);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param $wallet
     * @param $amount
     * @param $referral
     * @return Transaction|null
     */
    public static function partner($wallet, $amount, $referral)
    {
        $type = TransactionType::getByName('partner');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => 0,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'source'            => $referral->id,
            'approved'          => true,
        ]);

        $transaction->user->sendEmailNotification('ref_earnings', ['transaction' => $transaction], true);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param $wallet
     * @param $amount
     * @param null $referral
     * @param Deposit $deposit
     * @return Transaction|null
     */
    public static function dividend($wallet, $amount, Deposit $deposit, $referral=null)
    {
        $type = TransactionType::getByName('dividend');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => 0,
            'deposit_id'        => $deposit->id,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'source'            => null !== $referral
                ? $referral->id
                : null,
            'approved'          => true,
        ]);

        return $transaction->save() ? $transaction : null;

    }

    /**
     * @param $deposit
     * @return Transaction|null
     */
    public static function createDeposit($deposit)
    {
        $type = TransactionType::getByName('create_dep');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => 0,
            'user_id'           => $deposit->user->id,
            'currency_id'       => $deposit->currency->id,
            'rate_id'           => $deposit->rate->id,
            'deposit_id'        => $deposit->id,
            'wallet_id'         => $deposit->wallet->id,
            'payment_system_id' => $deposit->paymentSystem->id,
            'amount'            => $deposit->invested,
            'approved'          => true,
            'created_at'        => $deposit->created_at,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param $deposit
     * @param $amount
     * @return Transaction|null
     */
    public static function closeDeposit($deposit, $amount)
    {
        $type = TransactionType::getByName('close_dep');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => 0,
            'user_id'           => $deposit->user->id,
            'currency_id'       => $deposit->currency->id,
            'rate_id'           => $deposit->rate->id,
            'deposit_id'        => $deposit->id,
            'wallet_id'         => $deposit->wallet->id,
            'payment_system_id' => $deposit->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param $wallet
     * @param $amount
     * @return Transaction|null
     */
    public static function penalty($wallet, $amount)
    {
        $type = TransactionType::getByName('penalty');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => 0,
            'user_id'           => $wallet->user_id,
            'currency_id'       => $wallet->currency->id,
            'rate_id'           => null,
            'deposit_id'        => null,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @param $wallet
     * @param $amount
     * @return Transaction|null
     */
    public static function refback($wallet, $amount)
    {
        $type = TransactionType::getByName('refback');

        /** @var Transaction $transaction */
        $transaction = self::create([
            'type_id'           => $type->id,
            'commission'        => $type->commission,
            'user_id'           => $wallet->user->id,
            'currency_id'       => $wallet->currency->id,
            'wallet_id'         => $wallet->id,
            'payment_system_id' => $wallet->paymentSystem->id,
            'amount'            => $amount,
            'approved'          => true,
        ]);

        return $transaction->save()
            ? $transaction
            : null;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved == 1;
    }
}
