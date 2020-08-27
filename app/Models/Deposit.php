<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Deposit
 * @package App\Models
 *
 * @property string id
 * @property string currency_id
 * @property string wallet_id
 * @property string user_id
 * @property string rate_id
 * @property float daily
 * @property int duration
 * @property float payout
 * @property float invested
 * @property float balance
 * @property int reinvest
 * @property int autoclose
 * @property int active
 * @property Carbon datetime_closing
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Transaction transactions
 * @property DepositQueue queues
 * @property Currency currency
 * @property User user
 * @property Rate rate
 * @property Wallet wallet
 * @property PaymentSystem paymentSystem
 */
class Deposit extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'currency_id',
        'user_id',
        'wallet_id',
        'rate_id',
        'daily',
        'duration',
        'payout',
        'invested',
        'balance',
        'reinvest',
        'autoclose',
        'active',
        'datetime_closing',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'deposit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function queues()
    {
        return $this->hasMany(DepositQueue::class, 'deposit_id');
    }

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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rate()
    {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    /**
     * @return mixed
     */
    public function paymentSystem()
    {
        $wallet = $this->wallet;

        return null !== $wallet
            ? $wallet->paymentSystem()
            : null;
    }

    /**
     * @param array $data
     * @return Deposit|null
     * @throws \Exception
     *
     * required: user, wallet_id, amount, rate_id
     */
    public static function createDeposit($data=[])
    {
        /** @var User $user */
        $user = isset($data['user'])
            ? $data['user']
            : Auth::user();

        /** @var Wallet $wallet */
        $wallet = $user->wallets()
            ->where('id', $data['wallet_id'])
            ->first();

        /** @var float $amount */
        $amount = abs($data['amount']);

        $reinvest = isset($data['reinvest'])
            ? abs($data['reinvest'])
            : 0;

        /** @var Rate $rate */
        $rate = Rate::find($data['rate_id']);

        if ($rate->currency_id != $wallet->currency_id) {
            throw new \Exception('Wrong currency ID');
        }

        if ($amount < $rate->min || $amount > $rate->max) {
            throw new \Exception('Wrong deposit amount. Less or greater than in tariff plan.');
        }

        $wallet->removeAmount($amount);

        /** @var Deposit $deposit */
        $deposit = self::create([
            'rate_id'           => $rate->id,
            'currency_id'       => $rate->currency_id,
            'wallet_id'         => $wallet->id,
            'user_id'           => $user->id,
            'invested'          => $amount,
            'daily'             => $rate->daily,
            'duration'          => $rate->duration,
            'payout'            => $rate->payout,
            'balance'           => $amount,
            'reinvest'          => $reinvest,
            'autoclose'         => $rate->autoclose,
            'datetime_closing'  => now()->addDays($rate->duration)->toDateTimeString(),
            'created_at'        => isset($data['created_at']) ? $data['created_at'] : now()->toDateTimeString(),
            'active'            => true,
        ]);

        /** @var Transaction $transaction */
        $transaction = Transaction::createDeposit($deposit);

        $sequence = $deposit->createSequence();

        $deposit->user->sendEmailNotification('create_dep', ['deposit' => $deposit], true);

        return $deposit;
    }

    /**
     * @return bool
     */
    public function createSequence()
    {
        /** @var Rate $rate */
        $rate = $this->rate()->first();

        if (!is_int($this->duration) || $this->duration < 1) {
            return false;
        }

        if ($this->daily > 0) {
            for ($i = 1; $i <= $rate->duration; $i++) {
                $depositQueue = new DepositQueue();
                $depositQueue->deposit_id = $this->id;
                $depositQueue->setTypeAccrue();
                $depositQueue->setAvailableAt(now()->addDays($i));
                $depositQueue->save();
            };
        }

        if ($this->autoclose) {
            $depositQueue = new DepositQueue();
            $depositQueue->deposit_id = $this->id;
            $depositQueue->setTypeClosing();
            $depositQueue->setAvailableAt(now()->addDays($rate->duration)->addSeconds(30));
            $depositQueue->save();
        };

        return true;
    }

    /**
     * @param DepositQueue $depositQueue
     * @return bool
     * @throws \Throwable
     */
    public function accrue(DepositQueue $depositQueue)
    {
        $depositQueue->setIsDone()->save();

        $typeDividend = TransactionType::getByName('dividend');
        $checkExistsDividend = Transaction::where('deposit_id', $this->id)
            ->where('created_at', '>=', now()->format('Y-m-d 00:00:00'))
            ->where('type_id', $typeDividend->id)
            ->count();

        if ($checkExistsDividend > 0) {
            throw new \Exception('Deposit was accrued today.');
        }

        $countDividendTransactions = Transaction::where('deposit_id', $this->id)
                ->where('approved', true)
                ->where('type_id', $typeDividend->id)
                ->count();

        if ($this->duration < $countDividendTransactions) {
            throw new \Exception("too many transactions!");
        }

        /** @var Wallet $wallet */
        $wallet = $this->wallet;

        /** @var User $user */
        $user = $this->user;

        $reinvest = $this->reinvest ?? 0;
        $amountReinvest = $this->balance * $this->daily * 0.01 * $reinvest * 0.01;
        $amountToWallet = $this->balance * $this->daily * 0.01 - $amountReinvest;
        $dividend = Transaction::dividend($wallet, $amountToWallet, $this, null);

        $wallet->addAmountWithAccrueToPartner($amountToWallet, 'deposit');
        $this->addBalance($amountReinvest);

        $this->user->sendEmailNotification('deposit_earnings', ['deposit' => $this], true);

        return true;
    }

    /**
     * @param DepositQueue $depositQueue
     * @return bool
     * @throws \Throwable
     */
    public function close(DepositQueue $depositQueue)
    {
        $depositQueue->setIsDone()->save();

        if (!$this->active) {
            throw new \Exception("failed close");
        }

        /** @var Wallet $wallet */
        $wallet = $this->wallet;

        $amount = $this->invested / 100 * $this->payout;
        Transaction::closeDeposit($this, $amount);

        if ($amount > 0 && !$wallet->addAmountWithoutAccrueToPartner($amount)) {
            throw new \Exception("failed return deposit body!");
        }

        $this->update(['active' => false]);

        $this->user->sendEmailNotification('deposit_close', ['deposit' => $this], true);

        return true;
    }

    /**
     * @param float $amount
     * @return bool
     */
    public function addBalance($amount=0.00)
    {
        return $this->update([
            'balance' => $this->balance + $amount
        ]);
    }

    /**
     * @return bool
     */
    public function block()
    {
        if ($this->active != true) {
            return false;
        }

        $this->active = false;
        $this->save();

        return true;
    }

    /**
     * @return bool
     */
    public function unblock()
    {
        if ($this->active != false) {
            return false;
        }

        $this->active = true;
        $this->save();

        return true;
    }
}
