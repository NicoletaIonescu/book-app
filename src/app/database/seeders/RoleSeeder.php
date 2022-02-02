<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        //Permissions for superadmin
        Permission::create(['name' => 'manage accounts']);
        Permission::create(['name' => 'manage all users']);

        //Permissions for accountadmin
        Permission::create(['name' => 'manage users']);

        //Permissions for users


        $superAdmin= Role::create(['name' => 'super']);
        $superAdmin->givePermissionTo('manage accounts');
        $superAdmin->givePermissionTo('manage all users');

        $account = Role::create(['name' => 'account']);
        $account->givePermissionTo('manage accounts');

        $user = Role::create(['name' => 'user']);
    }
}
