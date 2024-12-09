<?php

namespace Database\Seeders;

use App\Models\AdminStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::where([
            'name' => 'Admin',
            'guard_name' => 'admin-staff',
        ])->first();

        $admin = AdminStaff::create([
            'nama' => 'Admin',
            'nidn' => '123456789',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole($roleAdmin);

        $roleStaff = Role::where([
            'name' => 'Staff',
            'guard_name' => 'admin-staff',
        ])->first();

        $staff = AdminStaff::create([
            'nama' => 'Staff',
            'nidn' => '123456789',
            'username' => 'staff',
            'password' => Hash::make('password'),
        ]);

        $staff->assignRole($roleStaff);

    }
}
