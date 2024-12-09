<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Role::create(
            [
                'name' => 'Admin',
                'guard_name' => 'admin-staff',
            ],
        );

        Role::create(
            [
                'name' => 'Staff',
                'guard_name' => 'admin-staff',
            ],
        );

        $this->command->info('Roles Admin dan Staff berhasil dibuat.');
    }
}
