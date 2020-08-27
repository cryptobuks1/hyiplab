<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Faq;
use App\Models\Language;
use App\Models\News;
use App\Models\Rate;
use App\Models\Referral;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Faker\Factory;

/**
 * Class GenerateDemoDataCommand
 * @package App\Console\Commands\Automatic
 */
class GenerateDemoDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:demo_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate demo data for the project';

    /** @var Factory */
    private $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /** @var Factory */
        $this->faker = Factory::create();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $this->comment('Reg program creating');
        $this->generateReferralLevels();

        $this->comment('Rates creating');
        $this->generateRates();

        $this->comment('Settings creating');
        $this->generateSettings();

        try {
            $this->comment('Rates');
            $this->call('update:currency_rates');
        } catch (\Exception $e) {
            $this->warn('can not update currency rates');
        }

        $this->comment('Users creating');
        $this->generateUsers();

        $this->comment('News creating');
        $this->generateNews();

        $this->comment('FAQ creating');
        $this->generateFaq();

        $this->comment('Review creating');
        $this->generateTestimonials();
    }

    public function generateReferralLevels()
    {
        for ($level = 1; $level <= $this->faker->numberBetween(3, 5); $level++) {
            Referral::create([
                'level'         => $level,
                'percent'       => $this->faker->numberBetween(1, 10),
                'on_load'       => 1,
                'on_profit'     => $this->faker->numberBetween(0, 1),
            ]);
            $this->info('level ' . $level . ' registered');
        }
    }

    public function generateRates()
    {
        /** @var Currency $currencies */
        $currencies = Currency::all();

        $count = 1;

        /** @var Currency $currency */
        foreach ($currencies as $currency) {
            $min = $this->faker->numberBetween(5, 20);
            $max = $count * $this->faker->numberBetween(50, 400);

            $newRate = [
                'currency_id' => $currency->id,
                'name'        => 'rate ' . $this->faker->domainWord,
                'min'         => $count == 1
                    ? $min
                    : $count * $min,
                'max'         => $count == 1
                    ? $max
                    : $count * $max,
                'daily'       => $this->faker->numberBetween(1, 5),
                'duration'    => $this->faker->numberBetween(3, 6),
                'payout'      => $this->faker->numberBetween(90, 100),
                'reinvest'    => $this->faker->numberBetween(0, 1),
                'autoclose'   => $this->faker->numberBetween(0, 1),
                'active'      => $count == 3 ? 0 : 1,
            ];

            /** @var Rate $rate */
            $rate = Rate::create($newRate);
            $this->info('rate ' . $rate->name . ' registered');

            $count++;
        }
    }

    public function generateSettings()
    {
        Setting::setValue('phone', $this->faker->phoneNumber);
        Setting::setValue('email', $this->faker->email);
        Setting::setValue('whatsapp', $this->faker->phoneNumber);
        Setting::setValue('company_name', $this->faker->company);
        Setting::setValue('address', $this->faker->address);
        Setting::setValue('working_time', '09:00 AM - 06:00 PM');
    }

    public function generateUsers()
    {
        $this->faker = Factory::create();

        for ($usersCount = 1; $usersCount <= $this->faker->numberBetween(30,100); $usersCount++) {
            $partnerId = User::select('my_id')
                ->inRandomOrder()
                ->limit(1)
                ->first();

            $newUser = [
                'name'       => $this->faker->name,
                'email'      => $this->faker->email,
                'login'      => $this->faker->word . '.' . $this->faker->word,
                'password'   => bcrypt('demopassword'),
                'partner_id' => !empty($partnerId)
                    ? $partnerId->my_id
                    : null,
                'created_at' => $this->faker->dateTimeThisMonth()->format('Y-m-d').' 12:00:00',
            ];

            $checkExists = User::where('login', $newUser['login'])
                ->orWhere('email', $newUser['email'])
                ->get()
                ->count();

            if ($checkExists > 0) {
                $this->warn('found user with same login or email, skipping.');
                continue;
            }

            /** @var User $user */
            $user = User::create($newUser);

            $this->generateBalances($user);
            $this->generateDeposits($user);
            $this->generateWithdrawals($user);

            $this->info('user ' . $user->name . ' registered');
        }
    }

    /**
     * @param User $user
     * @throws \Throwable
     */
    public function generateBalances(User $user)
    {
        $transactionType = TransactionType::getByName('enter');

        /** @var Wallet $wallet */
        foreach ($user->wallets()->get() as $wallet) {
            for($i = 1; $i <= $this->faker->numberBetween(3,5); $i++) {
                $amount             = $this->faker->numberBetween(10, 1000);
                $externalWallet     = 'W' . $this->faker->randomNumber(5);
                $transactionData    = [
                    'amount'            => $amount,
                    'type_id'           => $transactionType->id,
                    'user_id'           => $wallet->user_id,
                    'wallet_id'         => $wallet->id,
                    'currency_id'       => $wallet->currency_id,
                    'payment_system_id' => $wallet->payment_system_id,
                    'result'            => 'completed',
                    'batch_id'          => 'B'.$this->faker->randomNumber(5),
                    'approved'          => 1,
                    'log'               => $this->faker->text,
                    'created_at'        => $this->faker->dateTimeThisMonth()->format('Y-m-d').' 12:00:00',
                ];

                /** @var Transaction $transaction */
                $transaction = Transaction::create($transactionData);

                $wallet->refill($transaction->amount, $externalWallet);
            }
        }
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function generateWithdrawals(User $user)
    {
        $wallets = Wallet::where('user_id', $user->id)
            ->where('balance', '>', 10)
            ->inRandomOrder();

        if (0 === $wallets->count()) {
            return;
        }

        /** @var Wallet $wallet */
        foreach ($wallets->get() as $wallet) {
            $amount     = $wallet->balance / 10;

            /** @var Transaction $transaction */
            $transaction = Transaction::withdraw($wallet, $amount);

            if (null !== $transaction && $this->faker->boolean) {
                $transaction->created_at = $this->faker->dateTimeThisMonth()->format('Y-m-d').' 12:00:00';
                $transaction->approved = 1;
                $transaction->save();
            }
        }
    }

    /**
     * @param User $user
     * @throws \Throwable
     */
    public function generateDeposits(User $user)
    {
        /** @var Rate $randomRates */
        $randomRates = Rate::where('active', 1)
            ->inRandomOrder()
            ->get();

        if (null === $randomRates) {
            return;
        }

        /** @var Rate $randomRate */
        foreach ($randomRates as $randomRate) {
            /** @var Wallet $wallet */
            $wallet = $user->wallets()
                ->where('currency_id', $randomRate->currency_id)
                ->first();

            if (null === $wallet) {
                return;
            }

            $enterTransaction = TransactionType::getByName('enter');
            $externalWallet = 'W' . $this->faker->randomNumber(5);
            $transactionData = [
                'amount' => $randomRate->max,
                'type_id' => $enterTransaction->id,
                'user_id' => $wallet->user_id,
                'wallet_id' => $wallet->id,
                'currency_id' => $wallet->currency_id,
                'payment_system_id' => $wallet->payment_system_id,
                'result' => 'completed',
                'batch_id' => 'B' . $this->faker->randomNumber(5),
                'approved' => 1,
                'log' => $this->faker->text,
                'created_at' => $this->faker->dateTimeThisMonth()->format('Y-m-d') . ' 12:00:00',
            ];
            $wallet->refill($transactionData['amount'], $externalWallet);

            /** @var Transaction $transaction */
            $transaction = Transaction::create($transactionData);

            $min = $randomRate->min == 0
                ? 1
                : $randomRate->min;
            $depositAmount = $this->faker->numberBetween($min, $randomRate->max);
            $depositData = [
                'wallet_id' => $wallet->id,
                'rate_id' => $randomRate->id,
                'amount' => $depositAmount,
                'reinvest' => $randomRate->reinvest ? $this->faker->numberBetween(0, 20) : 0,
                'created_at' => $this->faker->dateTimeThisMonth()->format('Y-m-d') . ' 12:00:00',
                'user' => $wallet->user()->first(),
            ];

            /** @var Deposit $deposit */
            $deposit = Deposit::createDeposit($depositData);
        }
    }

    public function generateNews()
    {
        for ($i=0; $i<10; $i++) {
            $data = [
                'subject'       => $this->faker->title,
                'content'       => $this->faker->text,
                'language_id'   => Language::inRandomOrder()->limit(1)->first()->id,
                'created_at'    => $this->faker->dateTimeThisMonth()->format('Y-m-d').' 12:00:00',
            ];

            News::create($data);
            $this->comment('news '.$data['subject'].' generated');
        }
    }

    public function generateFaq()
    {
        for ($i=0; $i<10; $i++) {
            $data = [
                'question'          => $this->faker->text,
                'answer'            => $this->faker->text,
                'language_id'       => Language::inRandomOrder()->limit(1)->first()->id,
                'created_at'        => $this->faker->dateTimeThisMonth()->format('Y-m-d').' 12:00:00',
            ];

            Faq::create($data);
            $this->comment('faq '.$data['question'].' generated');
        }
    }

    public function generateTestimonials()
    {
        for ($i=0; $i<10; $i++) {
            $data = [
                'name'              => $this->faker->name,
                'email'             => $this->faker->email,
                'testimonial'       => $this->faker->text,
                'language_id'       => Language::inRandomOrder()->limit(1)->first()->id,
                'created_at'        => $this->faker->dateTimeThisMonth()->format('Y-m-d').' 12:00:00',
            ];

            Testimonial::create($data);
            $this->comment('testimonial '.$data['email'].' generated');
        }
    }
}
