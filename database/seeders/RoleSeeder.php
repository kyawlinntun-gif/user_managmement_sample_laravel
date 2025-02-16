<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'operator'],
            ['name' => 'cashier'],
            ['name' => 'manage']
        ];

        foreach ($roles as $new_role) {
            $role = new Role();
            $role->name = $new_role['name'];
            $role->save();
        }
    }
}
