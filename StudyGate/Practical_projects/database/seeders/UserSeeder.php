<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // يمكنك تغيير كلمة المرور
            'role' => 'admin',
        ]);
        
        User::create([
        'name' => 'موظف',
        'email' => 'staff@example.com',
        'password' => Hash::make('staff123'),
        'role' => 'staff',
    ]);

    User::create([
        'name' => 'طالب',
        'email' => 'student@example.com',
        'password' => Hash::make('student123'),
        'role' => 'student',
    ]);
    }
}
