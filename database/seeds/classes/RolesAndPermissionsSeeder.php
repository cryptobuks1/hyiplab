<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Class RolesAndPermissionsSeeder
 */
class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        $permissions = \App\Models\Admin::$listPermissions;

        foreach ($permissions as $permission) {
            if (\Spatie\Permission\Models\Permission::where('name', $permission)->count() == 0) {
                \Spatie\Permission\Models\Permission::create([
                    'name'          => $permission,
                    'guard_name'    => 'admin',
                ]);
                echo "Role '".$permission."' registered.\n";
            } else {
                echo "Role '".$permission."' already registered.\n";
            }
        }
    }
}
