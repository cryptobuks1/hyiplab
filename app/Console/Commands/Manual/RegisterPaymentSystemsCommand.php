<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Manual;

use App\Models\Currency;
use App\Models\PaymentSystem;
use Illuminate\Console\Command;

/**
 * Class RegisterPaymentSystemsCommand
 * @package App\Console\Commands\Manual
 */
class RegisterPaymentSystemsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:payment_systems {demo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register payment systems.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $paymentSystemModule = new PaymentSystem();
        $questions = $paymentSystemModule->systems;

        $counter = 0;

        foreach ($questions as $code => $question) {
            $questions[$code]['answer'] = $this->argument('demo') == true ? 'yes' : $this->ask($question['name'].' [yes|no]', 'yes');
            $counter++;
        }

        foreach ($questions as $paymentSystemCode => $data) {
            $this->line('------');

            if ('yes' !== $data['answer']) {
                continue;
            }

            $this->info('Registering ' . $paymentSystemCode);
            $checkExists = PaymentSystem::where('code', $paymentSystemCode)->get()->count();

            if ($checkExists > 0) {
                $this->error($paymentSystemCode . ' already registered.');
                continue;
            }

            /** @var PaymentSystem $reg */
            $reg = PaymentSystem::create([
                'name' => $data['name'],
                'code' => $paymentSystemCode
            ]);

            if (!$reg) {
                $this->error('Can not register ' . $paymentSystemCode);
                continue;
            }

            $this->info($paymentSystemCode . ' registered.');

            foreach ($data['currencies'] as $currency) {
                /** @var Currency $currencyInfo */
                $currencyInfo = Currency::where('code', $currency)->first();

                if (empty($currencyInfo)) {
                    $this->warn('currency ' . $currency . ' is not registered, ' . $paymentSystemCode . ' will be without ' . $currency);
                    continue;
                }

                \DB::table('currency_payment_system')->insert([
                    'currency_id' => $currencyInfo->id,
                    'payment_system_id' => $reg->id,
                ]);

                $this->info('currency ' . $currency . ' registered for ' . $paymentSystemCode);
            }
        }
    }
}
