<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

use Illuminate\Database\Seeder;

/**
 * Class LanguageSeeder
 */
class LanguageSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $languages = [
            'en' => [
                'code' => 'en',
                'default' => 0,
            ],
            'ru' => [
                'code' => 'ru',
                'default' => 1,
            ],
        ];

        foreach ($languages as $key => $language) {
            $checkExists = \App\Models\Language::where('code', $key)->count();

            if ($checkExists > 0) {
                echo "Language '".$key."' already registered.\n";
                continue;
            }

            \App\Models\Language::create($language);
            echo "Language '".$key."' registered.\n";
        }
    }
}
