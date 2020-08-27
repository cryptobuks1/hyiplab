<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App\Models
 *
 * @property string s_key
 * @property string s_value
 */
class Setting extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        's_key',
        's_value'
    ];

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public static function getValue(string $key, $default=null)
    {
        return cache()->rememberForever('model_setting_' . $key, function () use ($key, $default) {
            /** @var Setting $row */
            $row = self::where('s_key', $key)->first();

            if (null === $row) {
                return $default;
            }

            return !empty($row->s_value)
                ? $row->s_value
                : $default;
        });
    }

    /**
     * @param string $key
     * @param string|null $value
     * @return string
     */
    public static function setValue(string $key, string $value = null): string
    {
        $value = $value ?? '';
        $setting = self::updateOrCreate([
            's_key' => $key
        ], [
            's_value' => $value
        ]);
        return $setting ? $setting->s_value : '';
    }
}
