<?php
use Illuminate\Database\Seeder;

/**
 * Class CountriesSeeder
 */
class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $countries = Countries::getList();

        foreach ($countries as $countryId => $country) {
            $checkExists = DB::table(\Config::get('countries.table_name'))->where('id', $countryId)->count();

            if (!empty($checkExists)) {
                echo "Country '".$country['name']."'' already registered.\n";
                continue;
            }

            DB::table(\Config::get('countries.table_name'))->insert(array(
                'id'                => $countryId,
                'capital'           => $country['capital'] ?? null,
                'citizenship'       => $country['citizenship'] ?? null,
                'country_code'      => $country['country-code'],
                'currency'          => $country['currency'] ?? null,
                'currency_code'     => $country['currency_code'] ?? null,
                'currency_sub_unit' => $country['currency_sub_unit'] ?? null,
                'currency_decimals' => $country['currency_decimals'] ?? null,
                'full_name'         => $country['full_name'] ?? null,
                'iso_3166_2'        => $country['iso_3166_2'] ?? null,
                'iso_3166_3'        => $country['iso_3166_3'] ?? null,
                'name'              => $country['name'],
                'region_code'       => $country['region-code'] ?? null,
                'sub_region_code'   => $country['sub-region-code'] ?? null,
                'eea'               => (bool) $country['eea'],
                'calling_code'      => $country['calling_code'],
                'currency_symbol'   => $country['currency_symbol'] ?? null,
                'flag'              => $country['flag'] ?? null,
            ));

            echo "country '".$country['name']."' registered.\n";
        }
        echo "\n\n";
    }
}
