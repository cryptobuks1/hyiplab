<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;

/**
 * Class PerfectMoneyModule
 * @package App\Modules\PaymentSystems
 *
 * settings:
 * - account_id
 * - account_password
 * - payee_account_usd
 * - payee_account_eur
 * - withdraw_memo
 * - payee_name / ?
 * - sci_password / ?
 * - memo / ?
 */
class PerfectMoneyModule
{
    /**
     * @return array
     * @throws
     */
    public function getBalances(): array
    {
        $ps = PaymentSystem::getByCode('perfectmoney');

        $f = fopen('https://perfectmoney.is/acct/balance.asp?AccountID=' . $ps->getSetting('account_id') . '&PassPhrase=' . $ps->getSetting('account_password'), 'rb');

        if ($f === false) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception('error opening url');
        }

        $out = "";

        while (!feof($f)) {
            $out .= fgets($f);
        }
        fclose($f);

        // searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception('Error reading Perfectmoney response.');
        }

        // forming currency=>amount array
        foreach ($result as $item) {
            if (preg_match('/^U[0-9]+$/', $item[1])) {
                $balances['USD'] = $item[2];
            } elseif (preg_match('/^E[0-9]+$/', $item[1])) {
                $balances['EUR'] = $item[2];
            } elseif (preg_match('/^G[0-9]+$/', $item[1])) {
                $balances['GOLD'] = $item[2];
            }
        }

        if(isset($balances) && count($balances) > 0 && !empty($ps)){
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
        return isset($balances) ? $balances : [];
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
        $ps             = PaymentSystem::getByCode('perfectmoney');
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

        if ($currency->code == 'USD') {
            $account = $ps->getSetting('payee_account_usd');
        } elseif ($currency->code == 'EUR') {
            $account = $ps->getSetting('payee_account_eur');
        } else {
            throw new \Exception('PerfectMoney currency error');
        }

        $comment = $ps->getSetting('withdraw_memo');
        $comment = preg_replace('/\{login\}/', $user->login, $comment);
        $comment = preg_replace('/\{amount\}/', $transaction->amount, $comment);
        $comment = preg_replace('/\{project\}/', config('app.name'), $comment);

        $f = fopen('https://perfectmoney.is/acct/confirm.asp?AccountID=' . $ps->getSetting('account_id') .
            '&PassPhrase=' . $ps->getSetting('account_password') .
            '&Payer_Account='.$account.
            '&Payee_Account='.$wallet->external.
            '&Amount='.$transaction->amount.
            '&Memo='.urlencode($comment).
            '&PAY_IN=1&PAYMENT_ID='.$transaction->id, 'rb');

        if ($f === false) {
            throw new \Exception('Can not connect to PerfectMoney.');
        }

        // getting data
        $out = "";

        while (!feof($f)) {
            $out .= fgets($f);
        }
        fclose($f);

        // searching for hidden fields
        if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)) {
            throw new \Exception('Empty PerfectMoney response');
        }

        $ar = [];

        foreach ($result as $item) {
            $key      = $item[1];
            $ar[$key] = $item[2];
        }
        if (array_key_exists('ERROR', $ar)) {
            throw new \Exception('PerfectMoney transfer '.$transaction->amount.$currency->symbol.', '.$ar['ERROR']);
        }

        return $ar['PAYMENT_BATCH_NUM'];
    }
}