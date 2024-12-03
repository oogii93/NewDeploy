<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Car;
use App\Models\Corp;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Notifications\CarInsuranceExpiringNotification;

class CheckCarInsuranceExpiration extends Command
{
    protected $signature = 'car:check-insurance-expiration';
    protected $description = 'Check and notify about car insurance expiration';

    public function handle()
    {
        $this->info('Starting car insurance expiration check...');

        // Get all cars with insurance expiring within 7 weeks
        $sevenWeeksFromNow = now()->addWeeks(7);
        $expiringCars = Car::whereDate('car_insurance_end', '<=', $sevenWeeksFromNow)
            ->whereDate('car_insurance_end', '>', now())
            ->get();

        $this->info("Found {$expiringCars->count()} expiring cars");

        // Find the '太成HD' corporation
        $corp = Corp::where('corp_name', '太成HD')->first();
        if (!$corp) {
            $this->error('Corporation 太成HD not found');
            return;
        }

        // Find users in the '太成HD' corporation
        $users = User::whereHas('corp', function($query) use ($corp) {
            $query->where('id', $corp->id);
        })->get();

        foreach ($expiringCars as $car) {
            foreach ($users as $user) {
                $user->notify(new CarInsuranceExpiringNotification($car));
            }
        }

        $this->info('Car insurance expiration check completed.');
    }
}
