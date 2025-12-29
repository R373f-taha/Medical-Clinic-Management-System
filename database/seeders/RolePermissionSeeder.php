<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'create_patient', 'view_patient', 
            'create_appointment', 'view_appointment', 
            'create_invoice', 'view_invoice'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $roles = ['admin', 'doctor', 'receptionist'];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            if ($roleName === 'admin') {
                $role->givePermissionTo(Permission::all());
            } elseif ($roleName === 'doctor') {
                $role->givePermissionTo(['view_patient', 'create_appointment', 'view_appointment']);
            } elseif ($roleName === 'receptionist') {
                $role->givePermissionTo(['create_patient', 'view_patient', 'view_appointment']);
            }
        }
    }
}
