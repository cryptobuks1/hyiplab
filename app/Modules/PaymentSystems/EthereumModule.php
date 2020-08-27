<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

/**
 * Class EthereumModule
 * @package App\Modules\PaymentSystems
 *
 * settings:
 * - username
 * - api_key
 * - server_host
 * - parent_wallet
 * - parent_wallet_password
 * - gas_for_transaction
 * - gas_price
 */
class EthereumModule
{
    /**
     * @param $address
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($address, $data=[])
    {
        $ps = PaymentSystem::getByCode('ethereum');
        $client   = new \GuzzleHttp\Client();
        $baseData = [
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

        \Log::debug('Ethereum request params: '.print_r($params,true));

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

        \Log::debug('Got response from ethereum server: '.$content);

        return $content;
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalances()
    {
        $ps       = PaymentSystem::getByCode('ethereum');
        $balances = [];

        $balance = self::getBalance($ps->getSetting('parent_wallet'));
        \Log::info('Got Ethereum balance: '.$balance);

        $balances['ETH'] = (float) $balance;
        \Log::info('Prepared balance array: '.print_r($balances,true));

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
     * @param Transaction $transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getNewAddress(Transaction $transaction)
    {
        try {
            $newAddress = self::request('personal_newAccount', [
                md5($transaction->id),
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $newAddress;
    }

    /**
     * @param string $ethereumaddress
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalance(string $ethereumaddress)
    {
        try {
            $balance = self::request('eth_getBalance', [
                $ethereumaddress,
                'latest'
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return (float) self::wei2eth(self::bchexdec($balance));
    }

    /**
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getGasPrice()
    {
        try {
            $price = self::request('eth_gasPrice');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $price;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccounts()
    {
        try {
            $accounts = self::request('eth_accounts');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $accounts;
    }

    /**
     * @param string $ethereumSenderAddress
     * @param string $ethereumReceiverAddress
     * @param float $amountInEther
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendtoaddress(string $ethereumSenderAddress,
                                         string $ethereumReceiverAddress,
                                         float $amountInEther)
    {
        self::unlockAccount($ethereumSenderAddress);

        $ps  = PaymentSystem::getByCode('ethereum');
        $gas = $ps->getSetting('gas_for_transaction', 21000); // default from Ether
        $gasPrice = self::convertCurrency($ps->getSetting('gas_price', 3), 'gwei', 'wei');
        $fee = $gas*$gasPrice;
        $amountInWei = self::convertCurrency($amountInEther, 'ether', 'wei');
        $value = $amountInWei-$fee-($fee/100*1);

        try {
            $txid = self::request('eth_sendTransaction', [
                'from'      => $ethereumSenderAddress,
                'to'        => $ethereumReceiverAddress,
                'value'     => '0x'.dechex($value),
                'gas'       => '0x'.dechex($gas),
                'gasPrice'  => '0x'.dechex($gasPrice),
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $txid;
    }

    /**
     * @param string $account
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unlockAccount(string $account)
    {
        $ps = PaymentSystem::getByCode('ethereum');

        if ($account != $ps->getSetting('parent_wallet')) {
            /** @var Transaction $searchTransaction */
            $searchTransaction = Transaction::where('source', $account)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->first();

            if (null === $searchTransaction) {
                throw new \Exception('Transaction is not found for ' . $account . ' to unlock account.');
            }

            $password = md5($searchTransaction->id);
        } else {
            $password = md5($ps->getSetting('parent_wallet_password'));
        }

        try {
            $unlock = self::request('personal_unlockAccount', [
                $account,
                $password,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $unlock;
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function transfer(Transaction $transaction
    ) {
        $ps = PaymentSystem::getByCode('ethereum');

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

        $txid = self::sendtoaddress($ps->getSetting('parent_wallet'), $wallet->external, $transaction->amount);

        if (empty($txid)) {
            throw new \Exception('Can not withdraw '.$transaction->amount.$currency->symbol);
        }

        return $txid;
    }

    /**
     * @param $wei
     * @return string|null
     */
    public function wei2eth($wei)
    {
        return bcdiv($wei,1000000000000000000,18);
    }

    /**
     * @param $hex
     * @return float|int|string
     */
    public function bchexdec($hex) {
        if(strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, self::bchexdec($remain)), hexdec($last));
        }
    }

    /**
     * Convert from and to ether Ether
     *
     * Defaults from wei to ether.
     *
     * @param float $amount
     * @param string $from
     * @param string $to
     * @throws \Exception
     *
     * @return float
     */
    public function convertCurrency(float $amount, string $from = 'wei', string $to = 'ether') {
        // relative to Ether
        $convertTabe = [
            'wei' => 1000000000000000000,
            // Kwei, Ada, Femtoether
            'kwei' => 1000000000000000,
            // Mwei, Babbage, Picoether
            'mwei' => 1000000000000,
            // Gwei, Shannon, Nanoether, Nano
            'gwei' => 1000000000,
            // Szabo, Microether,Micro
            'methere' => 1000,
            'ether' => 1,
            // Kether, Grand,Einstein
            'kether' => 0.001,
            // Kether, Grand,Einstein
            'mether' => 0.000001,
            'gether' => 0.000000001,
            'thether' => 0.000000000001,
        ];
        if (!isset($convertTabe[$from])) {
            throw new \Exception('Unknown currency to convert from "' . $from . '"');
        }
        if (!isset($convertTabe[$to])) {
            throw new \Exception('Unknown currency to convert to "' . $to . '"');
        }
        return $convertTabe[$to] * $amount / $convertTabe[$from];
    }
}