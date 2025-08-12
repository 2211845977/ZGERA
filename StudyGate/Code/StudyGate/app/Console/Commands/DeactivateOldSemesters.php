<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Semester;

class DeactivateOldSemesters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * You will run this using: php artisan app:deactivate-old-semesters
     *
     * @var string
     */
    protected $signature = 'app:deactivate-old-semesters';

    /**
     * The console command description.
     *
     * Shown when running `php artisan list`
     *
     * @var string
     */
    protected $description = 'Deactivate semesters whose end date has already passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Semester::where('end_date', '<', now())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $this->info("✅ Deactivated $count old semester(s).");
    }
}
