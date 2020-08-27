<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Automatic;

use Illuminate\Console\Command;

/**
 * Class CleanDemoCommand
 * @package App\Console\Commands
 */
class CleanDemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all DEMO data';

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
     * Launch: php artisan cache:clear && php artisan config:cache && php artisan migrate:reset && php artisan migrate && php artisan db:seed && php artisan register:currencies true && php artisan register:payment_systems true && php artisan make:admin true && php artisan generate:demo_data
     * @return mixed
     */
    public function handle()
    {
        if (config('app.env') != 'demo') {
            $this->info('Project ENV is not DEMO. Skip cleaning.');
            return;
        }

        $this->call('clear-compiled');
        $this->call('cache:clear');

        $this->call('migrate:reset');
        $this->call('migrate');
        $this->call('db:seed');

        $this->call('register:currencies', [
            'demo' => true
        ]);
        $this->call('register:payment_systems', [
            'demo' => true
        ]);
        $this->call('make:admin', [
            'demo' => true
        ]);
        $this->call('generate:demo_data');
    }
}
