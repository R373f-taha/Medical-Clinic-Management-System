<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        //store the queries in the cache insteade of the memeory to make the application faster


        Permission::create(['name'=>'access admin panel']);
        Permission::create(['name'=>'manage users']);
        Permission::create(['name'=> 'manage patients']);
        Permission::create(['name'=> 'manage appointments']);
        Permission::create(['name'=> 'manage doctors']);
        Permission::create(['name'=> 'view reports']);
        Permission::create(['name'=> 'manage medical records']);
        Permission::create(['name'=> 'manage employees']);
        Permission::create(['name'=> 'manage clinic']);
        Permission::create(['name'=> 'manage ratings']);
        Permission::create(['name'=> 'manage invoices']);
        Permission::create(['name'=> 'view medical records']);
        Permission::create(['name'=>'create prescriptions']);
        Permission::create(['name'=> 'api:view invoices']);


        //permissions for  patients

        Permission::create(['name'=> 'api:view own appointments']);
        Permission::create(['name'=> 'api:book appointment']);
        Permission::create(['name'=> 'api:cancel own appointments']);
        Permission::create(['name'=> 'api:view own prescriptions']);
        Permission::create(['name'=> 'api:view own medical record']);
        Permission::create(['name'=> 'api:create rating']);
        Permission::create(['name'=> 'view rating']);


          //Permission::create(['name'=> 'view own mwedical record']);

        $clinicManager=Role::create(['name'=> 'clinicManager']);
        $clinicManager->givePermissionTo([
           'access admin panel','manage users','manage patients','manage appointments',
           'manage doctors','view reports', 'manage medical records','manage employees'
           ,'manage clinic','manage ratings', 'manage invoices'
          ]);
        $doctor=Role::create(['name'=> 'doctor']);
        $doctor->givePermissionTo(['manage patients',
          'manage medical records','manage appointments',
          'view rating']);
        $employee=Role::create(['name'=> 'employee']);
        $employee->givePermissionTo([
            'manage doctors','manage appointments']);
        $patient=Role::create(['name'=> 'patient']);
        $patient->givePermissionTo([
            'api:view own appointments', 'api:book appointment','api:cancel own appointments',
            'api:view own prescriptions','api:view own medical record','api:create rating',


        ]);

    }
}
