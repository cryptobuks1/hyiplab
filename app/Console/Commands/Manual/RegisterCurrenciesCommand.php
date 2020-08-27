<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Manual;

use App\Models\Currency;
use Illuminate\Console\Command;

/**
 * Class RegisterCurrenciesCommand
 * @package App\Console\Commands\Manual
 */
class RegisterCurrenciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:currencies {demo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register all needed currencies for project';

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
        $currencyModel = new Currency();
        $questions = $currencyModel->currencies;

        $counter = 0;

        foreach ($questions as $code => $question) {
            $questions[$code]['answer'] = $this->argument('demo') == true ? 'yes' : $this->ask($question['name'].' [yes|no]', 'yes');
            $counter++;
        }

        foreach ($questions as $currencyKey => $data) {
            $this->line('------');

            if ('yes' !== $data['answer']) {
                continue;
            }

            $this->info('Registering ' . $currencyKey);
            $checkExists = Currency::where('code', $currencyKey)->get()->count();

            if ($checkExists > 0) {
                $this->error($currencyKey . ' already registered.');
                continue;
            }

            /** @var Currency $reg */
            $reg = Currency::create([
                'name'        => $data['name'],
                'code'        => $currencyKey,
                'symbol'      => $data['symbol'],
                'precision'   => $data['precision'],
                'currency_id' => $data['currency_id'] ?? null,
                'is_fiat'     => $data['is_fiat'] ?? 1,
                'main_currency' => $data['main_currency'] ?? 0,
            ]);

            if (!$reg) {
                $this->error('Can not register ' . $currencyKey);
                continue;
            }

            $this->info($currencyKey . ' registered.');
        }
    }
}
