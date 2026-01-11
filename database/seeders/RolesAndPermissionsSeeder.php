<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============ WEB Permissions (For Admin Panel) ============
        $webPermissions = [
            'access admin panel',
            'manage users',
            'manage patients',
            'manage appointments',
            'manage doctors',
            'view reports',
            'manage medical records',
            'manage employees',
            'manage clinic',
            'manage ratings',
            'manage invoices',
            'view medical records',
            'create prescriptions',
            'view rating',
            'assign permissions' ,
            'assign roles' ,
             'revoke permissions',
             'manage permissions',
        ];

        foreach ($webPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // ============ API Permissions (For Patients) ============
        // Important: All must have guard_name = 'api'
        $apiPermissions = [
            ['name' => 'api:view own appointments', 'guard_name' => 'api'],
            ['name' => 'api:book appointment', 'guard_name' => 'api'],
            ['name' => 'api:cancel own appointments', 'guard_name' => 'api'],
            ['name' => 'api:view own prescriptions', 'guard_name' => 'api'],
            ['name' => 'api:view own medical record', 'guard_name' => 'api'],
            ['name' => 'api:create rating', 'guard_name' => 'api'],
            ['name' => 'api:view invoices', 'guard_name' => 'api'],
            ['name' => 'api:update appointment', 'guard_name' => 'api'],


        ];

        foreach ($apiPermissions as $permissionData) {
            Permission::firstOrCreate($permissionData);
        }


          $clinicManager = Role::create(['name' => 'clinicManager']);
          //تعريف مصفوفة بصلاحيات مدير العيادة 
          $managerPermissions = [
              'access admin panel',
              'manage users',
              'manage patients',
              'manage appointments',
              'manage doctors',
              'manage employees',
              'manage clinic',
              'manage medical records',
              'manage invoices',
              'manage ratings',
              'view reports'
          ];
          // إسناد الصلاحيات للدور
          $clinicManager->syncPermissions($managerPermissions);

          
        $doctor=Role::create(['name'=> 'doctor']);
        $doctor->givePermissionTo(['manage patients',
          'manage medical records','manage appointments',
          'view rating']);
        $employee=Role::create(['name'=> 'employee']);
        $employee->givePermissionTo([
            'manage doctors', 'manage appointments'
        ]);

        // Patient Role (API Only)
        $patient = Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'api']);

        // Assign API permissions to patient
        $patient->givePermissionTo([
            'api:view own appointments', 'api:book appointment', 'api:cancel own appointments',
            'api:view own prescriptions', 'api:view own medical record', 'api:create rating',
            'api:view invoices'
        ]);

        // Reset cache again to ensure fresh data
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }


}
   
