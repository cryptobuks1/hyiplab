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
 * Class Rate
 * @package App\Models
 *
 * @property string id
 * @property string currency_id
 * @property string name
 * @property float min
 * @property float max
 * @property float daily
 * @property integer duration
 * @property float payout
 * @property integer reinvest
 * @property integer autoclose
 * @property integer active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Currency currency
 * @property Deposit deposits
 * @property Transaction transactions
 */
class Rate extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'currency_id',
        'name',
        'min',
        'max',
        'daily',
        'duration',
        'payout',
        'reinvest',
        'autoclose',
        'active'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposits()
    {
        return $this->hasMany(Deposit::class,'rate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class,'rate_id');
    }
}
