<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * @package App\Models
 *
 * @property string id
 * @property string name
 * @property string code
 * @property integer main_currency
 * @property integer is_fiat
 * @property integer precision
 * @property string symbol
 * @property string|null currency_id
 *
 * @property PaymentSystem paymentSystems
 * @property Deposit deposits
 * @property Transaction transactions
 * @property Rate rates
 * @property Wallet wallets
 */
class Currency extends Model
{
    use Uuids;

    public $incrementing = false;

    /** @var array[] $currencies */
    public $currencies = [
        'USD' => [
            'name'      => 'U.S dollars',
            'symbol'    => '$',
            'precision' => 2,
            'is_fiat'   => 1,
            'main_currency' => 1,
        ],
        'EUR' => [
            'name'      => 'European euros',
            'symbol'    => '€',
            'precision' => 2,
            'is_fiat'   => 1,
        ],
        'RUB' => [
            'name'      => 'Russian rubles',
            'symbol'    => '₽',
            'precision' => 2,
            'is_fiat'   => 1,
        ],
        'BTC' => [
            'name'      => 'Bitcoins',
            'symbol'    => '฿',
            'precision' => 8,
            'is_fiat'   => 0,
        ],
        'LTC' => [
            'name'      => 'Litecoins',
            'symbol'    => 'Ł',
            'precision' => 8,
            'is_fiat'   => 0,
        ],
        'ETH' => [
            'name'      => 'Ether',
            'symbol'    => 'Ξ',
            'precision' => 8,
            'is_fiat'   => 0,
        ],
    ];

    protected $fillable = [
        'name',
        'code',
        'main_currency',
        'is_fiat',
        'precision',
        'symbol',
        'currency_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paymentSystems()
    {
        return $this->belongsToMany(PaymentSystem::class, 'currency_payment_system', 'currency_id', 'payment_system_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'currency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'currency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates()
    {
        return $this->hasMany(Rate::class, 'currency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'currency_id');
    }
}
