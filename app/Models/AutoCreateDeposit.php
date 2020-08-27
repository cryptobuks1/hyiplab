<?php
/**
 * Copyright. "Hyipium" engine. All rights reserved.
 * Any questions? Please, visit https://hyipium.com
 */

namespace App\Models;

use App\Traits\Uuids;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AutoCreateDeposit
 * @package App\Models
 *
 * @property string wallet_id
 * @property string rate_id
 * @property float amount
 * @property string user_id
 */
class AutoCreateDeposit extends Model
{
    use Uuids;

    public $incrementing = false;

    /** @var string $table */
    protected $table = 'auto_create_deposits';

    /** @var array $timestamps */
    public $timestamps = ['created_at', 'updated_at'];

    protected $fillable = [
        'wallet_id',
        'rate_id',
        'amount',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

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
}
