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
 * Class Language
 * @package App\Models
 *
 * @property string id
 * @property string code
 * @property integer default
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Language extends Model
{
    use Uuids;

    public $incrementing = false;

    /** @var string $table */
    protected $table = 'languages';

    /** @var array $timestamps */
    public $timestamps = ['created_at', 'updated_at'];

    /** @var array $fillable */
    protected $fillable = [
        'code',
        'default',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany(News::class, 'language_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faq()
    {
        return $this->hasMany(Faq::class, 'language_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'language_id');
    }
}