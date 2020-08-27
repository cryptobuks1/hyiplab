<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Faker\Provider\Payment;

require_once app_path() . '/Libraries/coinpayments.php';

/**
 * Class CoinpaymentsModule
 * @package App\Modules\PaymentSystems
 *
 * settings:
 * - private_key
 * - public_key
 * - memo
 * - ipn_secret / ?
 * - merchant_id / ?
 */
class CoinpaymentsModule
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getBalances(): array
    {
        $ps = PaymentSystem::getByCode('coinpayments');
        $cps = new \CoinPaymentsAPI();
        $cps->Setup($ps->getSetting('private_key'), $ps->getSetting('public_key'));
        $result = $cps->GetBalances();

        $ps       = PaymentSystem::getByCode('coinpayments');
        $balances = [];

        if ($result['error'] != 'ok' || !isset($result['result'])) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception("Coinpayments is not authorized.");
        }

        foreach ($result['result'] as $coin => $bal) {
            $balances[$coin] = $bal['balancef'];
        }

        $ps->update([
            'external_balances' => json_encode($balances),
            'connected'         => true,
        ]);

        return $balances;
    }

    /**
     * @param string $currency
     * @return float
     * @throws \Exception
     */
    public function getBalance(string $currency): float
    {
        $balances = self::getBalances();
        return key_exists($currency, $balances) ? $balances[$currency] : 0;
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     * @throws \Exception
     */
    public function transfer(Transaction $transaction
    ) {
        $ps = PaymentSystem::getByCode('coinpayments');
        $cps = new \CoinPaymentsAPI();
        $cps->Setup($ps->getSetting('private_key'), $ps->getSetting('public_key'));

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

        $result = $cps->CreateWithdrawal($transaction->amount, $currency->code, $wallet->external, true);

        if ($result['error'] != 'ok') {
            throw new \Exception('Can not withdraw '.$transaction->amount.$currency->symbol.'. Reason: '.$result['error']);
        }

        return $result['result']['id'];
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     * @throws \Exception
     */
    public function createTopupTransaction(Transaction $transaction)
    {
        $ps = PaymentSystem::getByCode('coinpayments');
        $cps = new \CoinPaymentsAPI();
        $cps->Setup($ps->getSetting('private_key'), $ps->getSetting('public_key'));

        $ps = PaymentSystem::getByCode('coinpayments');

        $req = [
            'amount'      => $transaction->amount,
            'currency1'   => strtoupper($transaction->currency->code),
            'currency2'   => strtoupper($transaction->currency->code),
            'address'     => '', // leave blank send to follow your settings on the Coin Settings page
            'item_name'   => $ps->getSetting('memo'),
            'ipn_url'     => route('coinpayments.status'),
            'buyer_email' => $transaction->user->email,
            'buyer_name'  => $transaction->user->login,
            'invoice'     => $transaction->id,
        ];

        $result = $cps->CreateTransaction($req);

        if ($result['error'] != 'ok' || !isset($result['result']['address'])) {
            throw new \Exception($result['error']);
        }

        return $result['result'];
    }
}