<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupUsersSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:setup {--fresh : Fresh migration and seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the users management system with sample data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 بدء إعداد نظام إدارة المستخدمين...');

        // Check if fresh option is used
        if ($this->option('fresh')) {
            $this->warn('⚠️  سيتم حذف جميع البيانات الموجودة وإعادة إنشاؤها!');
            
            if (!$this->confirm('هل أنت متأكد من المتابعة؟')) {
                $this->info('❌ تم إلغاء العملية.');
                return;
            }

            $this->info('🔄 تشغيل Fresh Migration...');
            Artisan::call('migrate:fresh');
            $this->info('✅ تم تشغيل Fresh Migration بنجاح.');
        } else {
            $this->info('🔄 تشغيل Migration...');
            Artisan::call('migrate');
            $this->info('✅ تم تشغيل Migration بنجاح.');
        }

        $this->info('🌱 تشغيل Seeder...');
        Artisan::call('db:seed');
        $this->info('✅ تم تشغيل Seeder بنجاح.');

        $this->info('🔑 إنشاء مفتاح التطبيق...');
        Artisan::call('key:generate');
        $this->info('✅ تم إنشاء مفتاح التطبيق بنجاح.');

        $this->info('📝 مسح الكاش...');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        $this->info('✅ تم مسح الكاش بنجاح.');

        $this->newLine();
        $this->info('🎉 تم إعداد نظام إدارة المستخدمين بنجاح!');
        $this->newLine();

        $this->info('📋 بيانات تسجيل الدخول:');
        $this->table(
            ['الدور', 'البريد الإلكتروني', 'كلمة المرور'],
            [
                ['مدير', 'admin@studygate.com', '12345678'],
                ['مدرس', 'ahmed.ali@studygate.com', '12345678'],
                ['طالب', 'ali.ahmed@studygate.com', '12345678'],
            ]
        );

        $this->newLine();
        $this->info('🌐 لتشغيل الخادم المحلي:');
        $this->line('   php artisan serve');
        $this->newLine();
        $this->info('🔗 ثم افتح المتصفح على: http://localhost:8000');
        $this->newLine();
        $this->info('📚 للمزيد من المعلومات، راجع ملف: USERS_MANAGEMENT_README.md');
    }
} 