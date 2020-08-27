<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Testimonial
 * @package App\Models
 *
 * @property string name
 * @property string email
 * @property string testimonial
 * @property Language language_id
 */
class Testimonial extends Model
{
    use Uuids;

    public $incrementing = false;

    /** @var string $table */
    protected $table = 'testimonials';

    /** @var array $timestamps */
    public $timestamps = ['created_at', 'updated_at'];

    /** @var array $fillable */
    protected $fillable = [
        'name',
        'email',
        'testimonial',
        'language_id',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}