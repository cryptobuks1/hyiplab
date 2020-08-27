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
 * Class Referral
 * @package App\Models
 *
 * @property integer level
 * @property float percent
 * @property integer on_load
 * @property integer on_profit
 * @property integer on_task
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Referral extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'level',
        'percent',
        'on_load',
        'on_profit',
        'on_task',
    ];

    /**
     * @param $level
     * @return int
     */
    public static function getOnLoad($level)
    {
        if ($referral = self::where('level', $level)->first()) {
            if ($referral->on_load) return $referral->percent;
            return 0;
        }
        return 0;

    }

    /**
     * @param $level
     * @return int
     */
    public static function getOnProfit($level)
    {
        if ($referral = self::where('level', $level)->first()) {
            if ($referral->on_profit) return $referral->percent;
            return 0;
        }
        return 0;
    }
}
