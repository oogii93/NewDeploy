<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Corp;
use App\Models\User;
use App\Notifications\CarInsuranceExpiringNotification;
use Illuminate\Http\Request;

class CarInsuranceTestController extends Controller
{
    // public function testNotification()
    // {
    //     // Find the corporation
    //     $corp = Corp::where('corp_name', '太成HD')->first();

    //     // dd($corp);
    //     if (!$corp) {
    //         return "Corporation not found";
    //     }

    //     // Get a car with insurance expiring soon
    //     $car = Car::where('corp_id', $corp->id)
    //         ->whereDate('car_insurance_end', '<=', now()->addWeeks(10))
    //         ->first();

    //     if (!$car) {
    //         return "No cars found with insurance expiring soon";
    //     }

    //     // Find users in the same corporation
    //     $users = User::whereHas('corp', function($query) use ($corp) {
    //         $query->where('id', $corp->id);
    //     })->get();

    //     foreach ($users as $user) {
    //         $user->notify(new CarInsuranceExpiringNotification($car));
    //     }

    //     return "Sent " . $users->count() . " notifications for car: " . $car->number_plate;
    // }
}
