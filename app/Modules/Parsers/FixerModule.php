<?php
namespace App\Modules\Parsers;

use App\Models\Setting;
use GuzzleHttp\Client;

/**
 * Class FixerModule
 * @package App\Modules\Parsers
 */
class FixerModule
{
    /** @var string $api */
    private $api = 'http://data.fixer.io/api/';

    /**
     * @param string $method
     * @param string|null $type
     * @param array|null $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    public function sendRequest(string $method, string $type=null, array $data=null)
    {
        if (null === $type) {
            $type = 'GET';
        }

        if (null === $data) {
            $data = [];
        }

        $client   = new Client();
        $baseUrl  = $this->api;
        $headers  = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $verify   = config('app.env') == 'production' ? true : false;
        $params   = [
            'headers' => $headers,
            'verify'  => $verify,
        ];

        if (!empty($data)) {
            $params['form_params'] = $data;
        }

        try {
            $response = $client->request($type, $baseUrl.$method, $params);
        } catch (\Exception $e) {
            throw new \Exception('FixerModule API request is failed. '.$e->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('FixerModule API response status is '.$response->getStatusCode().' for method '.$method);
        }

        $body = json_decode($response->getBody()->getContents());

        return $body;
    }

    /**
     * @param $from
     * @param array $symbols
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|\Exception
     */
    public static function getRate($from, array $symbols)
    {
        $access_key = Setting::getValue('FIXER_ACCESS_KEY', env('FIXER_ACCESS_KEY'));
        $symbols    = implode(',', $symbols);

        try {
            $response = (new FixerModule())->sendRequest('latest?access_key='.$access_key.'&base='.$from.'&symbols='.$symbols.'&format=1', 'GET');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $response;
    }
}