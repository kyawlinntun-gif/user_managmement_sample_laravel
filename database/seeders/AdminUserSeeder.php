<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_users = [
            ['name' => 'Kyaw Kyaw', 'username' => 'kyawkyaw', 'role_id' => 1, 'phone' => '09796937456', 'email' => 'kyawkyaw@gmail.com', 'address' => 'bahan', 'password' => password_hash('password', PASSWORD_BCRYPT), 'gender' => 1, 'is_active' => 1],
            ['name' => 'Aung Aung', 'username' => 'aungaung', 'role_id' => 2, 'phone' => '09796937456', 'email' => 'aungaung@gmail.com', 'address' => 'bahan', 'password' => password_hash('password', PASSWORD_BCRYPT), 'gender' => 1, 'is_active' => 1],
            ['name' => 'Mg Mg', 'username' => 'mgmg', 'role_id' => 4, 'phone' => '09796937456', 'email' => 'mgmg@gmail.com', 'address' => 'mandalay', 'password' => password_hash('password', PASSWORD_BCRYPT), 'gender' => 1, 'is_active' => 1],
            ['name' => 'Aye Aye', 'username' => 'ayeaye', 'role_id' => null, 'phone' => '09796937456', 'email' => 'ayeaye@gmail.com', 'address' => 'rakhine', 'password' => password_hash('password', PASSWORD_BCRYPT), 'gender' => 0, 'is_active' => 0],
        ];
        foreach ($admin_users as $new_user) {
            $admin_user = new AdminUser();
            $admin_user->name = $new_user['name'];
            $admin_user->username = $new_user['username'];
            $admin_user->role_id = $new_user['role_id'];
            $admin_user->phone = $new_user['phone'];
            $admin_user->email = $new_user['email'];
            $admin_user->address = $new_user['address'];
            $admin_user->password = $new_user['password'];
            $admin_user->gender = $new_user['gender'];
            $admin_user->is_active = $new_user['is_active'];
            $admin_user->save();
        }
    }
}
