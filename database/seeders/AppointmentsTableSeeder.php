<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        // Adjust the number of records as needed (e.g., 80000)
        Appointment::factory(10000)->create();
    }
}