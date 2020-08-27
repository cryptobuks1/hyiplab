<?php
/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

namespace App\Console\Commands\Manual;

use App\Models\Admin;
use Faker\Factory;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

/**
 * Class CreateAdminCommand
 * @package App\Console\Commands\Manual
 */
class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {demo?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating admin';

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
        $this->line('------');

        $login = $this->argument('demo') == true ? 'demo' : $this->ask('Admin login', false);

        $checkExistsLogin = \App\Models\Admin::where('login', $login)->first();

        if (!empty($checkExistsLogin)) {
            $this->comment('Admin with this login already exists');
            return;
        }

        $askPassword = $this->argument('demo') == true ? 'demo' : $this->ask('Admin password [keep empty to generate automatically]', false);

        if (empty($askPassword)) {
            $this->comment('Password will be generated automatically.');
        }

        if ($this->argument('demo') != true) {
            $askAllFine = $this->ask('Is this data correct? login: ' . $login . ', password: ' . $askPassword . ' [yes|no]');

            if ('yes' != $askAllFine) {
                $this->info('Okay, trying again.');
                $this->call('make:admin');
                return;
            }
        }

        $password = empty($askPassword) ? str_random(12) : $askPassword;

        /** @var Admin $admin */
        $admin = \App\Models\Admin::create([
            'login'    => $login,
            'password' => bcrypt($password),
        ]);

        if (config('app.env') == 'demo') {
            $user = \App\Models\User::create([
                'login'    => $login,
                'password' => bcrypt($password),
            ]);
        }

        /** @var Permission $permissions */
        $permissions = Permission::all();

        /** @var Permission $permission */
        foreach($permissions as $permission) {
            $admin->givePermissionTo($permission->name);
        }

        $this->info('registered admin [ALL PERMISSIONS]:');
        $this->comment('login: ' . $login);
        $this->comment('password: ' . $password);
    }
}
