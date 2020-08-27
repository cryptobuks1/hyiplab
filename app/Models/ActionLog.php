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
 * Class ActionLog
 * @package App\Models
 *
 * @property User user_id
 * @property integer is_admin
 * @property string action
 * @property string get_data
 * @property string post_data
 * @property string user_ip
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property User user
 * @property User admin
 */
class ActionLog extends Model
{
    use Uuids;

    public $incrementing = false;

    /** @var string $table */
    protected $table = 'action_logs';

    /** @var array $timestamps */
    public $timestamps = ['created_at', 'updated_at'];

    /** @var array $fillable */
    protected $fillable = [
        'user_id',
        'is_admin',
        'action',
        'get_data',
        'post_data',
        'user_ip',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    /**
     * @param string $action
     * @return mixed
     */
    public static function addRecord(string $action, $recordData=true)
    {
        $user  = auth()->user();

        if (null == $user) {
            $user  = auth()->guard('admin')->user();
        }

        return self::create([
            'user_id'       => $user->id ?? null,
            'is_admin'      => activeGuard() == 'admin',
            'action'        => $action,
            'get_data'      => true == $recordData ? json_encode($_GET) : null,
            'post_data'     => true == $recordData ? json_encode($_POST) : null,
            'user_ip'       => $_SERVER['REMOTE_ADDR'],
        ]);
    }
}