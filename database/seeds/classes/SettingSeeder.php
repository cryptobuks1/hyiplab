<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

use Illuminate\Database\Seeder;

/**
 * Class SettingSeeder
 */
class SettingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $settings = [
            'site-on'       => '1',
            'support-email' => 'admin@hyiplab.net',
        ];

        foreach ($settings as $settingKey => $settingValue) {
            $checkExists = DB::table('settings')->where('s_key', $settingKey)->count();

            if ($checkExists > 0) {
                echo "Setting '".$settingKey."' already registered.\n";
                continue;
            }

            DB::table('settings')->insert([
                's_key' => $settingKey,
                's_value' => $settingValue,
                'created_at' => now()
            ]);
            echo "Setting '".$settingKey."' registered.\n";
        }
    }
}
