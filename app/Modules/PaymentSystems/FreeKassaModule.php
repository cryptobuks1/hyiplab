<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

/**
 * Class FreeKassaModule
 * @package App\Modules\PaymentSystems
 *
 * settings:
 * - wallet_id
 * - api_key
 * - withdraw_memo
 * - merchant_id / ?
 * - merchant_key / ?
 * - memo / ?
 */
class FreeKassaModule
{
    /** @var string $code */
    protected $code = 'free-kassa';

    /**
     * @param array|null $data
     * @return mixed
     * @throws \Exception
     */
    public function sendRequest(array $data=null)
    {
        sleep(3);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.fkwallet.ru/api_v1.php');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = trim(curl_exec($ch));
        $c_errors = curl_error($ch);

        curl_close($ch);

        if (!preg_match('/info/', $result)) {
            throw new \Exception('error: '.print_r($result,true));
        }

        return json_decode($result);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getBalances(): array
    {
        /** @var PaymentSystem $ps */
        $ps = self::getPaymentSystem();

        $balances = [];

        /** @var Currency $currency */
        foreach ($ps->currencies()->get() as $currency) {
            $balances[$currency->code] = self::getBalance($currency->code);
        }

        if (isset($balances) && count($balances) > 0 && !empty($ps)) {
            $ps->update([
                'external_balances' => json_encode($balances),
                'connected' => true,
            ]);
        } else {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception('Balance is not reachable.');
        }

        return $balances;
    }

    /**
     * @param string $currency
     * @return float
     * @throws \Exception
     */
    public function getBalance(string $currency): float
    {
        $ps         = PaymentSystem::getByCode('free-kassa');
        $signStr    = $ps->getSetting('wallet_id').$ps->getSetting('api_key');
        $data       = [
            'wallet_id' => $ps->getSetting('wallet_id'),
            'sign'      => md5($signStr),
            'action'    => 'get_balance',
        ];

        try {
            $response = (new FreeKassaModule())->sendRequest($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        \Log::debug('Free-kassa balances: '.print_r($response,true));

        if ($currency == 'RUR') {
            $currency = 'RUB';
        }

        if (isset($response->data->{$currency})) {
            return $response->data->{$currency};
        }

        return 0;
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     * @throws \Exception
     */
    public function transfer(Transaction $transaction) {
        $ps = PaymentSystem::getByCode('free-kassa');

        /** @var Wallet $wallet */
        $wallet         = $transaction->wallet()->first();
        /** @var User $user */
        $user           = $wallet->user()->first();
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem  = $wallet->paymentSystem()->first();
        /** @var Currency $currency */
        $currency       = $wallet->currency()->first();

        if (null === $wallet || null === $user || null === $paymentSystem || null === $currency) {
            throw new \Exception('Wallet, user, payment system or currency is not found for withdrawal approve.');
        }

        /** @var Wallet $wallet */
        $wallet         = $transaction->wallet()->first();
        /** @var User $user */
        $user           = $wallet->user()->first();
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem  = $wallet->paymentSystem()->first();
        /** @var Currency $currency */
        $currency       = $wallet->currency()->first();

        if (null === $wallet || null === $user || null === $paymentSystem || null === $currency) {
            throw new \Exception('Wallet, user, payment system or currency is not found for withdrawal approve.');
        }

        $memo = $ps->getSetting('withdraw_memo');
        $memo = preg_replace('/\{login\}/', $user->login, $memo);
        $memo = preg_replace('/\{amount\}/', $transaction->amount, $memo);
        $memo = preg_replace('/\{project\}/', config('app.name'), $memo);

        $amount = number_format($transaction->amount, 2, '.', '');

        switch ($this->code) {
            case "qiwi":
                $serviceId = 63;
                break;

            case "visa_mastercard":
                $serviceId = 94;
                break;

            case "yandex":
                $serviceId = 45;
                break;

            case "free-kassa":
                $serviceId = 133;
                break;

            default:
                throw new \Exception('service id not found');
        }

        $data = array(
            'wallet_id'     =>  $ps->getSetting('wallet_id'),
            'purse'         =>  $wallet->external,
            'amount'        =>  $amount,
            'desc'          =>  $memo,
            'currency'      =>  $serviceId,
            'sign'          =>  md5($ps->getSetting('wallet_id').$serviceId.$amount.$wallet->external.$ps->getSetting('api_key')),
            'action'        =>  'cashout',
        );

        try {
            $response = (new FreeKassaModule())->sendRequest($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        \Log::debug('Free-kassa withdraw: '.print_r($response,true));

        if (isset($response->data->payment_id)) {
            return $response->data->payment_id;
        }

        throw new \Exception(print_r($response,true));
    }

    /**
     * @return PaymentSystem|null
     */
    public function getPaymentSystem()
    {
        /** @var PaymentSystem $ps */
        return PaymentSystem::getByCode($this->code);
    }
}