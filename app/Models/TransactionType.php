<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionType
 * @package App\Models
 *
 * @property string id
 * @property string name
 * @property float commission
 *
 * @property Transaction transactions
 */
class TransactionType extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'name',
        'commission',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'type_id');
    }

    /**
     * @param $name
     * @return TransactionType
     * @throws
     */
    public static function getByName($name)
    {
        return cache()->rememberForever('model_setting_' . $name, function () use ($name) {
            return self::where('name', $name)->first();
        });
    }
}
