<?php
namespace App\Modules\PaymentSystems;

use App\Models\Currency;
use App\Models\PaymentSystem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Exception;

require_once app_path() . '/Libraries/MerchantWebService.php';

/**
 * Class AdvcashModule
 * @package App\Modules\Messangers
 *
 * settings:
 * - api_name
 * - account_email
 * - authentication_token
 * - withdraw_memo
 * - memo / ?
 * - sci_name / ?
 * - sci_password / ?
 */
class AdvcashModule
{
    /**
     * @return array
     * @throws Exception
     */
    public function getBalances(): array
    {
        $ps = PaymentSystem::getByCode('advcash');

        $merchantWebService = new \MerchantWebService();
        $arg0 = new \authDTO();
        $arg0->apiName = $ps->getSetting('api_name');
        $arg0->accountEmail = $ps->getSetting('account_email');
        $arg0->authenticationToken = $merchantWebService->getAuthenticationToken($ps->getSetting('authentication_token'));

        $getBalances       = new \getBalances();
        $getBalances->arg0 = $arg0;

        try {
            $getBalancesResponse = $merchantWebService->getBalances($getBalances);
        } catch (Exception $e) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception($e->getMessage());
        }

        $balances = [];

        if (!isset($getBalancesResponse->return)) {
            $ps->update([
                'external_balances' => json_encode([]),
                'connected' => false,
            ]);
            throw new \Exception("Can not get advcash balance.");
        }

        foreach ($getBalancesResponse->return as $item) {
            if (!isset($item->id) || !isset($item->amount)) {
                $ps->update([
                    'external_balances' => json_encode([]),
                    'connected' => false,
                ]);
                throw new \Exception('Wrong Advcash balance server response.');
            }

            if (preg_match('/^U[0-9]{12}$/', $item->id)) {
                $balances['USD'] = $item->amount;
            } elseif (preg_match('/^E[0-9]{12}$/', $item->id)) {
                $balances['EUR'] = $item->amount;
            } elseif (preg_match('/^R[0-9]{12}$/', $item->id)) {
                $balances['RUB'] = $item->amount;
            }
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
     * @throws Exception
     */
    public function getBalance(string $currency): float
    {
        $balances = self::getBalances();
        return key_exists($currency, $balances) ? $balances[$currency] : 0;
    }

    /**
     * @param Transaction $transaction
     * @return string
     * @throws Exception
     */
    public function transfer(Transaction $transaction
    ) {
        $ps = PaymentSystem::getByCode('advcash');

        $merchantWebService = new \MerchantWebService();
        $arg0 = new \authDTO();
        $arg0->apiName = $ps->getSetting('api_name');
        $arg0->accountEmail = $ps->getSetting('account_email');
        $arg0->authenticationToken = $merchantWebService->getAuthenticationToken($ps->getSetting('authentication_token'));

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

        $arg1 = new \sendMoneyRequest();
        $arg1->amount = sprintf("%.2f", $transaction->amount);
        $arg1->currency = $currency->code;

        if (preg_match('/\@/', $wallet->external)) {
            $arg1->email    = $wallet->external;
        } else {
            $arg1->walletId = $wallet->external;
        }

        $comment = $ps->getSetting('withdraw_memo');
        $comment = preg_replace('/\{login\}/', $user->login, $comment);
        $comment = preg_replace('/\{amount\}/', $transaction->amount, $comment);
        $comment = preg_replace('/\{project\}/', config('app.name'), $comment);

        $arg1->note = $comment;
        $arg1->savePaymentTemplate = false;

        $validationSendMoney = new \validationSendMoney();
        $validationSendMoney->arg0 = $arg0;
        $validationSendMoney->arg1 = $arg1;

        $sendMoney = new \sendMoney();
        $sendMoney->arg0 = $arg0;
        $sendMoney->arg1 = $arg1;

        try {
            $merchantWebService->validationSendMoney($validationSendMoney);
            $sendMoneyResponse = $merchantWebService->sendMoney($sendMoney);

            return $sendMoneyResponse->return;
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $batchId
     * @return \outcomingTransactionDTO
     * @throws Exception
     */
    public function checkAcceptedTransfer(string $batchId)
    {
        $merchantWebService = new \MerchantWebService();
        $arg0 = new \authDTO();
        $arg0->apiName = $ps->getSetting('api_name');
        $arg0->accountEmail = $ps->getSetting('account_email');
        $arg0->authenticationToken = $merchantWebService->getAuthenticationToken($ps->getSetting('authentication_token'));

        $arg1 = trim($batchId);

        $findTransaction = new \findTransaction();
        $findTransaction->arg0 = $arg0;
        $findTransaction->arg1 = $arg1;

        try {
            $merchantWebService = $merchantWebService->findTransaction($findTransaction);

            return $merchantWebService->return;
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}