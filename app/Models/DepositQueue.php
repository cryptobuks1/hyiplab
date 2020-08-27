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
 * Class DepositQueue
 * @package App\Models
 *
 * @property string id
 * @property string deposit_id
 * @property integer type
 * @property integer available_at
 * @property integer done
 * @property integer fired
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Deposit deposit
 */
class DepositQueue extends Model
{
    CONST TYPE_ACCRUE = 1;
    CONST TYPE_CLOSING = 2;

    use Uuids;

    public $incrementing = false;

    /** @var string $table */
    protected $table = 'deposit_queue';

    /** @var array $timestamps */
    public $timestamps = ['created_at', 'updated_at'];

    /** @var array $fillable */
    protected $fillable = [
        'deposit_id',
        'type',
        'available_at',
        'done',
        'fired',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id');
    }

    /**
     * @return $this
     */
    public function setTypeAccrue()
    {
        $this->type = self::TYPE_ACCRUE;
        return $this;
    }

    /**
     * @return $this
     */
    public function setTypeClosing()
    {
        $this->type = self::TYPE_CLOSING;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTypeAccrue()
    {
        return $this->type == self::TYPE_ACCRUE;
    }

    /**
     * @return bool
     */
    public function isTypeClosing()
    {
        return $this->type == self::TYPE_CLOSING;
    }

    /**
     * @param Carbon $carbon
     * @return $this
     */
    public function setAvailableAt(Carbon $carbon)
    {
        $this->available_at = $carbon;
        return $this;
    }

    /**
     * @return $this
     */
    public function setIsDone()
    {
        $this->done = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->done == 1;
    }
}