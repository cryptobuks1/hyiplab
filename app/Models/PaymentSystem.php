<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Models;

use App\Modules\PaymentSystems\AdvcashModule;
use App\Modules\PaymentSystems\BitcoinModule;
use App\Modules\PaymentSystems\CoinpaymentsModule;
use App\Modules\PaymentSystems\EthereumModule;
use App\Modules\PaymentSystems\FreeKassaModule;
use App\Modules\PaymentSystems\PayeerModule;
use App\Modules\PaymentSystems\PerfectMoneyModule;
use App\Modules\PaymentSystems\QiwiModule;
use App\Modules\PaymentSystems\VisaMastercardModule;
use App\Modules\PaymentSystems\YandexModule;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentSystem
 * @package App\Models
 *
 * @property string id
 * @property string name
 * @property string code
 * @property string instant_limit
 * @property string settings
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property string external_balances
 * @property int connected
 * @property string minimum_topup
 * @property string minimum_withdraw
 *
 * @property Currency currencies
 * @property Wallet wallets
 * @property Transaction transactions
 */
class PaymentSystem extends Model
{
    use Uuids;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'name',
        'id',
        'code',
        'instant_limit',
        'settings',
        'external_balances',
        'connected',
        'minimum_topup',
        'minimum_withdraw',
    ];

    public $systems = [
        'perfectmoney' => [
            'name' => 'Perfect Money',
            'currencies' => [
                'USD',
                'EUR',
            ],
            'settings' => [
                'account_id' => 'show',
                'account_password' => 'hide',
                'payee_account_usd' => 'show',
                'payee_account_eur' => 'show',
                'withdraw_memo' => 'show',
                'payee_name' => 'show',
                'sci_password' => 'hide',
                'memo' => 'show',
            ],
        ],
        'advcash' => [
            'name' => 'Advcash',
            'currencies' => [
                'USD',
                'EUR',
                'RUB',
            ],
            'settings' => [
                'api_name' => 'show',
                'account_email' => 'show',
                'authentication_token' => 'hide',
                'withdraw_memo' => 'show',
                'memo' => 'show',
                'sci_name' => 'show',
                'sci_password' => 'hide',
            ],
        ],
        'payeer' => [
            'name' => 'Payeer',
            'currencies' => [
                'USD',
                'EUR',
                'RUB',
            ],
            'settings' => [
                'account_number' => 'show',
                'api_id' => 'show',
                'api_key' => 'hide',
                'withdraw_memo' => 'show',
                'merchant_id' => 'show',
                'merchant_key' => 'hide',
                'memo' => 'show',
            ],
        ],
        'coinpayments' => [
            'name' => 'Coinpayments',
            'currencies' => [
                'BTC',
                'LTC',
                'BCH',
                'ETH',
            ],
            'settings' => [
                'private_key' => 'hide',
                'public_key' => 'show',
                'memo' => 'show',
                'ipn_secret' => 'hide',
                'merchant_id' => 'show',
            ],
        ],
        'bitcoin' => [
            'name' => 'Bitcoin',
            'currencies' => [
                'BTC',
            ],
            'settings' => [
                'username' => 'show',
                'api_key' => 'hide',
                'server_host' => 'show',
            ],
        ],
        'ethereum' => [
            'name' => 'Ethereum',
            'currencies' => [
                'ETH',
            ],
            'settings' => [
                'username' => 'show',
                'api_key' => 'hide',
                'server_host' => 'show',
            ],
        ],
        'free-kassa' => [
            'name' => 'Free-Kassa',
            'currencies' => [
                'USD',
                'EUR',
                'RUB',
            ],
            'settings' => [
                'wallet_id' => 'show',
                'api_key' => 'hide',
                'withdraw_memo' => 'show',
                'merchant_id' => 'show',
                'merchant_key' => 'hide',
                'memo' => 'show',
            ],
        ],
        'yandex' => [
            'name' => 'Yandex',
            'currencies' => [
                'RUB',
            ],
            'settings' => [
                'wallet_id' => 'show',
                'api_key' => 'hide',
                'withdraw_memo' => 'show',
                'merchant_id' => 'show',
                'merchant_key' => 'hide',
                'memo' => 'show',
            ],
        ],
        'qiwi' => [
            'name' => 'Qiwi',
            'currencies' => [
                'RUB',
            ],
            'settings' => [
                'wallet_id' => 'show',
                'api_key' => 'hide',
                'withdraw_memo' => 'show',
                'merchant_id' => 'show',
                'merchant_key' => 'hide',
                'memo' => 'show',
            ],
        ],
        'visa_mastercard' => [
            'name' => 'Visa/Mastercard',
            'currencies' => [
                'RUB',
            ],
            'settings' => [
                'wallet_id' => 'show',
                'api_key' => 'hide',
                'withdraw_memo' => 'show',
                'merchant_id' => 'show',
                'merchant_key' => 'hide',
                'memo' => 'show',
            ],
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class, 'currency_payment_system', 'payment_system_id', 'currency_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class, 'payment_system_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'payment_system_id');
    }

    /**
     * @param string $code
     * @return PaymentSystem|null
     */
    public static function getByCode(string $code)
    {
        return PaymentSystem::where('code', $code)->first();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getClassInstance()
    {
        $pss = [
            'advcash'               => new AdvcashModule(),
            'perfectmoney'          => new PerfectMoneyModule(),
            'payeer'                => new PayeerModule(),
            'coinpayments'          => new CoinpaymentsModule(),
            'free-kassa'            => new FreeKassaModule(),
            'yandex'                => new YandexModule(),
            'qiwi'                  => new QiwiModule(),
            'visa_mastercard'       => new VisaMastercardModule(),
            'bitcoin'               => new BitcoinModule(),
            'ethereum'              => new EthereumModule(),
        ];

        if (!key_exists($this->code, $pss)) {
            throw new \Exception($this->code.' class not found');
        }

        return $pss[$this->code];
    }

    /**
     * @param string|null $key
     * @return mixed|null
     */
    public function getSetting($key=null, $default=null)
    {
        $key        = strtolower(trim($key));
        $settings   = $this->settings;

        if (empty($settings)) {
            return $default;
        }

        $arr = json_decode($settings, true);

        if (null != $key) {
            return isset($arr[$key])
                ? $arr[$key]
                : $default;
        }

        return $arr;
    }

    /**
     * @param string $key
     * @param string $val
     * @return $this|bool
     */
    public function setSetting(string $key, string $val)
    {
        $key        = strtolower(trim($key));
        $settings   = $this->settings;
        $arr        = !empty($settings)
            ? json_decode($settings, true)
            : [];

        if (empty($key)) {
            return false;
        }

        $arr[$key] = $val;
        $encodeSettings = json_encode($arr);
        $this->settings = $encodeSettings;
        $this->save();

        return $this;
    }
}
