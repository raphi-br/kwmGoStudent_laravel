<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appointment = new \App\Models\Appointment;
        $appointment->date = new Carbon('2022-01-23');
        $appointment->time = new Carbon('12:00:00');

        $offer = Offer::all()->first();
        $appointment->offer()->associate($offer);

        $user = User::all()->first();
        $appointment->user()->associate($user);
        $appointment->save();
    }
}
