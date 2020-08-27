<?php
namespace App\Modules\Parsers;

use App\Models\Setting;
use GuzzleHttp\Client;

/**
 * Class CoinmarketcapModule
 * @package App\Modules\Parsers
 */
class CoinmarketcapModule
{
    /**
     * @param string|null $action
     * @param array|null $parameters
     * @return mixed
     * @throws \Exception
     */
    public function sendRequest(string $action=null, array $parameters=null)
    {
        $url = 'https://pro-api.coinmarketcap.com/v1/'.$action;

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: '.Setting::getValue('COINMARKETCAP_ACCESS_KEY', env('COINMARKETCAP_ACCESS_KEY'))
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        curl_close($curl); // Close request

        $response = json_decode($response, true);

        if (!isset($response['status']['error_code']) || $response['status']['error_code'] != 0) {
            throw new \Exception('Error request to Coinmarketcap. '.print_r($response,true));
        }

        return $response;
    }

    /**
     * @param $from
     * @param array $symbols
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    public static function getRate(string $code)
    {
        try {
            $response = (new CoinmarketcapModule())->sendRequest('/cryptocurrency/quotes/latest', [
                'symbol' => $code,
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $response;
    }
}