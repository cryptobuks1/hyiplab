<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

/**
 * Class BitcoinModule
 * @package App\Modules\PaymentSystems
 *
 * https://habr.com/ru/post/350430/
 *
 * settings:
 * - username
 * - api_key
 * - server_host
 */
class BitcoinModule
{
    /**
     * @param $address
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($address, $data=[])
    {
        $ps         = PaymentSystem::getByCode('bitcoin');
        $client     = new \GuzzleHttp\Client();
        $baseData   = [
            'username'      => $ps->getSetting('username'),
            'api_key'       => $ps->getSetting('api_key'),
            'call_method'   => $address,
        ];
        $formParams     = $baseData;

        if (count($data)) {
            $formParams['params'] = $data;
        }

        $requestParams  = http_build_query($formParams);
        $params   = [
            'verify'        => false,
        ];

        \Log::debug('Bitcoin request params: '.print_r($params,true));

        try {
            $response = $client->request('GET', $ps->getSetting('server_host').'/?'.$requestParams, $params);
        } catch (\Exception $e) {
            throw new \Exception('Request to '.$address.' is failed. '.$e->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Request to '.$address.' was with response status '.$response->getStatusCode());
        }

        $content = $response->getBody()->getContents();

        if (preg_match('/error\:/', $content)) {
            throw new \Exception('Error: '.$content);
        }

        \Log::debug('God response from bitcoin server: '.$content);

        return $content;
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalances()
    {
        $ps       = PaymentSystem::getByCode('bitcoin');
        $balances = [];

        try {
            $balance = self::request('getbalance');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $balances['BTC'] = $balance;

        if (count($balances) > 0 && !empty($ps)) {
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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getnewaddress()
    {
        try {
            $newAddress = self::request('getnewaddress');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $newAddress;
    }

    /**
     * @param string $bitcoinaddress
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getreceivedbyaddress(string $bitcoinaddress)
    {
        try {
            $received = self::request('getreceivedbyaddress', [
                $bitcoinaddress
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $received;
    }

    /**
     * @param string $txid
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gettransaction(string $txid)
    {
        try {
            $transaction = self::request('gettransaction', [
                $txid
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $transaction;
    }

    /**
     * @param string $bitcoinaddress
     * @param float $amount
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendtoaddress(string $bitcoinaddress, float $amount)
    {
        try {
            $txid = self::request('sendtoaddress', [
                $bitcoinaddress,
                $amount,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $txid;
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transfer(Transaction $transaction
    ) {
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

        $txid = self::sendtoaddress($wallet->external, $transaction->amount);

        if (empty($txid)) {
            throw new \Exception('Can not withdraw '.$transaction->amount.$currency->symbol);
        }

        return $txid;
    }
}