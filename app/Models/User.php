<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Mail\NotificationMail;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class User
 * @package App\Models
 *
 * @property string id
 * @property string name
 * @property string email
 * @property string login
 * @property string password
 * @property string phone
 * @property string partner_id
 * @property string my_id
 * @property string remember_token
 * @property string sex
 * @property string country
 * @property string city
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon email_verified_at
 * @property Carbon email_verification_sent
 * @property string email_verification_hash
 * @property integer representative
 * @property integer blocked
 * @property integer email_tester
 * @property string notifications_settings
 * @property string pin
 *
 * @property Transaction transactions
 * @property User partner
 * @property User left_line
 * @property Deposit left_line_deposits
 * @property User right_line
 * @property Wallet wallets
 * @property Deposit deposits
 * @property Deposit right_line_deposits
 * @property MailSent mailSents
 * @property User referrals
 * @property Deposit referralsDeposits
 * @property User partners
 * @property ActionLog actionLogs
 */
class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use HasRoles;
    use Uuids;
    use Impersonate;
    use HasMediaTrait;

    /** @var bool $incrementing */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'login',
        'password',
        'my_id',
        'partner_id',
        'phone',
        'skype',
        'created_at',
        'sex',
        'city',
        'country',
        'email_verified_at',
        'email_verification_sent',
        'email_verification_hash',
        'representative',
        'blocked',
        'email_tester',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actionLogs()
    {
        return $this->hasMany(ActionLog::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function partner()
    {
        return $this->hasOne(User::class, 'my_id', 'partner_id');
    }

    /**
     * @param User $parent
     */
    public function generatePartnerTree(User $parent)
    {
        $parent_array = [];

        $partners = $parent->partners()->orderBy('pivot_line','asc')->get();
        $parent_array[$parent->id] = ['line'=>1];

        $i = 1;

        foreach ($partners as $partner) {
            $i++;
            $parent_array[$partner->id] = ['line'=>$i];
        }

        $this->partners()->sync($parent_array);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function left_line()
    {
        return $this->referrals()->wherePivot('main_parent_id', '!=', $this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function left_line_deposits()
    {
        return $this->referralsDeposits()->wherePivot('main_parent_id', '!=', $this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function right_line()
    {
        return $this->referrals()->wherePivot('main_parent_id', $this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function right_line_deposits()
    {
        return $this->referralsDeposits()->wherePivot('main_parent_id', $this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mailSents()
    {
        return $this->hasMany(MailSent::class, 'user_id');
    }

    /**
     * @return bool
     */
    public function hasReferrals()
    {
        return $this->referrals()->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function referrals()
    {
        return $this->belongsToMany(User::class, 'user_parents', 'parent_id', 'user_id')
            ->withPivot([
                'line',
                'main_parent_id'
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function referralsDeposits()
    {
        return $this->belongsToMany(Deposit::class, 'user_parents', 'parent_id', 'user_id', null, 'user_id')
            ->withPivot([
                'line',
                'main_parent_id'
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function partners()
    {
        return $this->belongsToMany(User::class, 'user_parents', 'user_id', 'parent_id')
            ->withPivot([
                'line',
                'main_parent_id'
            ]);
    }

    /**
     * @return array
     */
    public function getLevels()
    {
        $levels     = [];
        $referrals  = $this->referrals()
            ->get()
            ->groupBy('pivot.line', true);

        foreach ($referrals as $level => $allReferral) {
            $levels[$level] = $allReferral->count();
        }

        return $levels;
    }

    /**
     * @param int $level
     * @return mixed
     * @throws \Exception
     */
    public function getLevels24h()
    {
        $levels = [];

        $referrals = $this->referrals()
            ->where('created_at', '>=', now()->subHours(24)->toDateTimeString())
            ->get()
            ->groupBy('pivot.line', true);

        foreach ($referrals as $level => $allReferral) {
            $levels[$level] = $allReferral->count();
        }

        return $levels;
    }

    /**
     * @return array
     */
    public function getAllReferralsArray()
    {
        /** @var User $referrals */
        $referrals = $this->referrals()
            ->get()
            ->groupBy('pivot.line', true);

        return $referrals->toArray();
    }

    /**
     * @param $level
     * @return int
     */
    public function getReferralOnLoadPercent($level)
    {
        return Referral::getOnLoad($level);
    }

    /**
     * @param $level
     * @return int
     */
    public function getReferralOnProfitPercent($level)
    {
        return Referral::getOnProfit($level);
    }

    /**
     * @return array
     */
    public function getPartnerLevels()
    {
        $levels = $this->partners()
            ->get()
            ->pluck('pivot.line')
            ->toArray();

        return !empty($levels)
            ? $levels
            : [];
    }

    /**
     * @param int $level
     * @param bool $json
     * @return User
     */
    public function getPartnerOnLevel(int $level)
    {
        /** @var User $partner */
        $partner = $this->partners()
            ->wherePivot('line', $level)
            ->first();

        return $partner;
    }

    /**
     * @param string $code
     * @param array $data
     * @param bool $skipVerified
     * @param int $delay
     * @return bool
     * @throws \Throwable
     */
    public function sendEmailNotification(string $code, array $data, bool $skipVerified=false, int $delay=0)
    {
        if (false === $skipVerified
            && config('mail.usersShouldVerifyEmail') == true
            && false === $this->isVerifiedEmail()) {
            \Log::info('User email is not verified for accepting mails.');
            return false;
        }

        $subjectView = 'mail.'.$code.'.subject';
        $bodyView    = 'mail.'.$code.'.body';

        if (!view()->exists($subjectView) || !view()->exists($bodyView)) {
            return false;
        }

        $html = view('mail.'.$code.'.body', array_merge([
            'user'      => $this,
        ], $data))->render();

        if (empty($html)) {
            return false;
        }

        if ($this->getNotificationSettings($code, null) != 'on') {
            return false;
        }

        $notificationMail = (new NotificationMail($this->email, $code, $data))
            ->onQueue(getSupervisorName().'-emails')
            ->delay(now()->addSeconds($delay));

        \Mail::to($this->email)->queue($notificationMail);
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = Hash::make($password);
        $this->save();

        return $this;
    }

    /**
     * @param string $pin
     * @return User
     */
    public function setPin(string $pin): User
    {
        $this->pin = Hash::make($pin);
        $this->save();

        return $this;
    }

    /**
     * @return bool
     */
    public function isMan()
    {
        return $this->sex == 'man';
    }

    /**
     * @return bool
     */
    public function isWoman()
    {
        return $this->sex == 'woman';
    }

    /**
     * @return bool
     */
    public function isVerifiedEmail()
    {
        return $this->email_verified_at !== null;
    }

    /**
     * @return bool
     */
    public function canSendVerificationEmail()
    {
        if ($this->email_verification_sent == null) {
            return true;
        }

        return abs(Carbon::parse($this->email_verification_sent)->diffInMinutes(now())) > 1;
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public function sendVerificationEmail()
    {
        if (config('mail.usersShouldVerifyEmail') != true) {
            return false;
        }

        if (false === $this->canSendVerificationEmail()) {
            return false;
        }

        if (empty($this->email)) {
            return false;
        }

        $this->email_verification_sent = now();
        $this->email_verification_hash = md5($this->email.config('app.name'));
        $this->save();

        $this->sendEmailNotification('email_verification', [
            'email_verification_hash' => $this->email_verification_hash,
        ], true);

        return true;
    }

    /**
     * @param string|null $email
     * @return string
     */
    private function getEmailVerificationHash(string $email=null)
    {
        if (null === $email) {
            return null;
        }

        return md5($email.config('app.name'));
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public function refreshEmailVerificationAndSendNew()
    {
        if ($this->email_verification_hash != $this->getEmailVerificationHash($this->email)) {
            return $this->sendVerificationEmail();
        }
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(env('AVATAR_WIDTH', 145))
            ->height(env('AVATAR_HEIGHT', 145));
    }

    /**
     * @return bool
     */
    public function isRepresentative()
    {
        return $this->representative == 1;
    }

    /**
     * @return bool
     */
    public function isBlocked()
    {
        return $this->blocked == 1;
    }

    /**
     * @param string $key
     * @param string $val
     * @return array|mixed
     */
    public function setNotificationSettings(string $key, string $val)
    {
        $settings = !empty($this->notifications_settings)
            ? (array) $this->notifications_settings
            : [];

        $settings[$key] = $val;

        $this->notifications_settings = $settings;
        $this->save();

        return $settings;
    }

    /**
     * @param string $key
     * @param string|null $default
     * @return mixed|string|null
     */
    public function getNotificationSettings(string $key, string $default=null)
    {
        $settings = !empty($this->notifications_settings)
            ? json_decode($this->notifications_settings, true)
            : [];

        return isset($settings[$key])
            ? $settings[$key]
            : $default;
    }
}
