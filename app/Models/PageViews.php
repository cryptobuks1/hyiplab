<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class PageViews
 * @package App\Models
 *
 * @property string user_id
 * @property string page_url
 * @property string user_ip
 * @property string get_request
 * @property string post_request
 *
 * @property User user
 */
class PageViews extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        'user_id',
        'page_url',
        'user_ip',
        'get_request',
        'post_request',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public static function addRecord()
    {
        $user = auth()->user();

        if (null == $user) {
            $user = auth()->guard('admin')->user();
        }

        return self::create([
            'user_id'       => $user->id ?? null,
            'page_url'      => url()->full(),
            'user_ip'       => $_SERVER['REMOTE_ADDR'],
            'get_request'   => json_encode($_GET),
            'post_request'  => json_encode($_POST),
        ]);
    }
}
