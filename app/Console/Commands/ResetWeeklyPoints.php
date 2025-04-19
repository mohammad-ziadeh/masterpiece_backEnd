<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetWeeklyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-weekly-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    User::query()->update([
        'weekly_points' => 1000,
        'last_reset_at' => now()->startOfWeek(),
    ]);

    $this->info('Weekly points reset successfully!');
}
}
