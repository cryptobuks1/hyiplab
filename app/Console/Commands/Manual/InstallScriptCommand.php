<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Manual;

use Illuminate\Console\Command;

/**
 * Class InstallScriptCommand
 * @package App\Console\Commands\Manual
 */
class InstallScriptCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing script data';

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
        $this->info('Clear cache:');
        $this->call('cache:clear');

        $this->line('===================================');

        $this->info('Generating APP KEY:');
        $this->call('key:generate');

        $this->line('===================================');

        $this->info('Migrations:');
        $this->call('migrate');

        $this->line('===================================');

        $this->info('DB seeds:');
        $this->call('db:seed');

        $this->line('===================================');

        $this->info('Registering currencies:');
        $this->call('register:currencies');

        $this->line('===================================');

        $this->info('Registering payment systems:');
        $this->call('register:payment_systems');

        $this->line('===================================');

        $this->info('Registering admin user:');
        $this->call('make:admin');
    }
}
