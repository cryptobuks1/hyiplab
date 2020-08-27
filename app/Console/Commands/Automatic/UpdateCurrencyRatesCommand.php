<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use App\Models\Currency;
use App\Models\Setting;
use App\Modules\Parsers\CoinmarketcapModule;
use App\Modules\Parsers\FixerModule;
use Illuminate\Console\Command;

/**
 * Class UpdateCurrencyRatesCommand
 * @package App\Console\Commands\Automatic
 */
class UpdateCurrencyRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:currency_rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all currency exchange rates.';

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
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    public function handle()
    {
        // FIAT: USD, EUR, RUR
        // CRYPTO: BTC, LTC, ETH

        $cryptoCurrencies = Currency::where('is_fiat', 0)->get();

        /** @var Currency $currency */
        foreach($cryptoCurrencies as $currency) {
            $response = CoinmarketcapModule::getRate(strtoupper($currency->code));

            if (!isset($response['data'][strtoupper($currency->code)]['quote']['USD']['price'])) {
                \Log::error('Can not get rate for '.$currency->code.' in USD');
                continue;
            }

            $rateInUsd = (float) amountWithPrecision($response['data'][strtoupper($currency->code)]['quote']['USD']['price'], $currency);

            $key = strtolower($currency->code).'_to_usd';
            Setting::setValue($key, $rateInUsd);
            $this->comment('updated '.$key.' = '.$rateInUsd);

            $key = 'usd_to_'.strtolower($currency->code);
            Setting::setValue($key, 1/$rateInUsd);
            $this->comment('updated '.$key.' = '.(1/$rateInUsd));
        }

        $fiatCurrencies = Currency::where('is_fiat', 1)->get();

        /** @var Currency $currency */
        foreach($fiatCurrencies as $currency) {
            $response = FixerModule::getRate(strtoupper($currency->code), [
                'USD',
                'EUR',
                'RUB'
            ]);

            if (!isset($response->rates)) {
                \Log::error('Error getting rate for '.$currency->code);
                continue;
            }

            $response = (array) $response;
            $response['rates'] = (array) $response['rates'];

            foreach ($response['rates'] as $code => $rate) {
                $key = strtolower($currency->code).'_to_'.strtolower($code);
                Setting::setValue($key, $rate);
                $this->comment('updated '.$key.' = '.$rate);

                $key = strtolower($code).'_to_'.strtolower($currency->code);
                Setting::setValue($key, 1/$rate);
                $this->comment('updated '.$key.' = '.(1/$rate));
            }
        }
    }
}
