<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Services\AttendanceReminderService;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $reminderService = new AttendanceReminderService();

        // // Send clock-in reminders at 9:00 AM every day
        // $schedule->call(function () use ($reminderService) {
        //     $reminderService->sendClockInReminders();
        // })->dailyAt('09:00');

        // // Send clock-out reminders at 11:00 PM every day
        // $schedule->call(function () use ($reminderService) {
        //     $reminderService->sendClockOutReminders();
        // })->dailyAt('23:00');
        $schedule->command('car:check-insurance-expiration')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


}
