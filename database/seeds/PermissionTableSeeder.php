<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'users',
            'projects',
            'amendments',
            'comp_profile',
            'userprofiles',
            'Payment-create',
            'payment-index',
            'payment-verify',
            'payment-approve',
            'voucher_create',
            'voucher_approved',
            'payment-edit',




        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


    }
}
