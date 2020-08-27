<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;

/**
 * Class PayeerModule
 * @package App\Modules\PaymentSystems
 *
 * settings:
 * - account_number
 * - api_id
 * - api_key
 * - withdraw_memo
 * - merchant_id / ?
 * - merchant_key / ?
 * - memo / ?
 */
class PayeerModule
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getBalances(): array
    {
        $ps = PaymentSystem::getByCode('payeer');

        $cPayeer = new \CPayeer(
            $ps->getSetting('account_number'),
            $ps->getSetting('api_id'),
            $ps->getSetting('api_key')
        );

        if (false === $cPayeer->isAuth()) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception("Payeer is not authorized.");
        }

        $arrayBalances = $cPayeer->getBalance();
        $balances      = [];

        if (!isset($arrayBalances['balance'])) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception("Can not get payeer balance");
        }

        foreach ($arrayBalances['balance'] as $key => $value) {
            $balances[$key] = isset($value['DOSTUPNO'])
                ? $value['DOSTUPNO']
                : 0;
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
        $ps             = PaymentSystem::getByCode('payeer');
        /** @var Wallet $wallet */
        $wallet         = $transaction->wallet()->first();
        /** @var \App\User $user */
        $user           = $wallet->user()->first();
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem  = $wallet->paymentSystem()->first();
        /** @var Currency $currency */
        $currency       = $wallet->currency()->first();

        if (null === $wallet || null === $user || null === $paymentSystem || null === $currency) {
            throw new \Exception('Wallet, user, payment system or currency is not found for withdrawal approve.');
        }

        $cPayeer = new \CPayeer(
            $ps->getSetting('account_number'),
            $ps->getSetting('api_id'),
            $ps->getSetting('api_key')
        );

        if (false === $cPayeer->isAuth()) {
            $paymentSystem->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception("Payeer is not authorized.");
        }

        $comment = $ps->getSetting('withdraw_memo');
        $comment = preg_replace('/\{login\}/', $user->login, $comment);
        $comment = preg_replace('/\{amount\}/', $transaction->amount, $comment);
        $comment = preg_replace('/\{project\}/', config('app.name'), $comment);

        $arTransfer = $cPayeer->transfer(array(
            'curIn' => $currency->code,
            'sum' => $transaction->amount,
            'curOut' => $currency->code,
            //'sumOut' => 1,
            'to' => $wallet->external,
            //'to' => 'client@mail.com',
            'comment' => $comment,
            //'protect' => 'Y',
            //'protectPeriod' => '3',
            //'protectCode' => '12345',
        ));

        if (!empty($arTransfer['errors'])) {
            throw new \Exception(print_r($arTransfer["errors"], true));
        }

        return $arTransfer['historyId'];
    }
}