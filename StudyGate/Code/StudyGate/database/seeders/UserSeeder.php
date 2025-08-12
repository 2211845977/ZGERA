<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // إنشاء مدير افتراضي
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone_number' => '0501234567',
            'address' => 'الرياض، المملكة العربية السعودية',
            'gender' => 'male',
            'birthdate' => '1985-01-15',
        ]);

        // إنشاء مدرسين تجريبيين
        User::create([
            'name' => 'أحمد محمد علي',
            'email' => 'ahmed.ali@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher',
            'phone_number' => '0502345678',
            'address' => 'جدة، المملكة العربية السعودية',
            'gender' => 'male',
            'birthdate' => '1980-03-20',
        ]);

        User::create([
            'name' => 'فاطمة أحمد حسن',
            'email' => 'fatima.hassan@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher',
            'phone_number' => '0503456789',
            'address' => 'الدمام، المملكة العربية السعودية',
            'gender' => 'female',
            'birthdate' => '1982-07-10',
        ]);

        User::create([
            'name' => 'محمد عبدالله سالم',
            'email' => 'mohammed.salem@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'teacher',
            'phone_number' => '0504567890',
            'address' => 'مكة المكرمة، المملكة العربية السعودية',
            'gender' => 'male',
            'birthdate' => '1978-11-05',
        ]);

        // إنشاء طلاب تجريبيين
        User::create([
            'name' => 'علي محمد أحمد',
            'email' => 'ali.ahmed@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'phone_number' => '0505678901',
            'address' => 'الرياض، المملكة العربية السعودية',
            'gender' => 'male',
            'birthdate' => '2000-05-15',
        ]);

        User::create([
            'name' => 'سارة أحمد محمد',
            'email' => 'sara.mohammed@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'phone_number' => '0506789012',
            'address' => 'جدة، المملكة العربية السعودية',
            'gender' => 'female',
            'birthdate' => '2001-08-22',
        ]);

        User::create([
            'name' => 'عبدالله علي حسن',
            'email' => 'abdullah.hassan@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'phone_number' => '0507890123',
            'address' => 'الدمام، المملكة العربية السعودية',
            'gender' => 'male',
            'birthdate' => '1999-12-03',
        ]);

        User::create([
            'name' => 'نور محمد علي',
            'email' => 'noor.ali@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'phone_number' => '0508901234',
            'address' => 'مكة المكرمة، المملكة العربية السعودية',
            'gender' => 'female',
            'birthdate' => '2002-02-18',
        ]);

        User::create([
            'name' => 'يوسف أحمد محمد',
            'email' => 'youssef.mohammed@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'phone_number' => '0509012345',
            'address' => 'المدينة المنورة، المملكة العربية السعودية',
            'gender' => 'male',
            'birthdate' => '2000-09-30',
        ]);

        User::create([
            'name' => 'مريم علي أحمد',
            'email' => 'maryam.ahmed@studygate.com',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'phone_number' => '0500123456',
            'address' => 'تبوك، المملكة العربية السعودية',
            'gender' => 'female',
            'birthdate' => '2001-04-12',
        ]);
    }
} 