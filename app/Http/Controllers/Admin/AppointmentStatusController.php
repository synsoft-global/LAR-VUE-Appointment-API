<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;

class AppointmentStatusController extends Controller
{
    /**
     * Retrieve status counts for appointments.
     *
     * This method is responsible for retrieving the count of appointments
     * for each appointment status. It iterates over all appointment status
     * cases and queries the database to count the number of appointments
     * with each status. It returns a collection containing status names,
     * values, counts, and associated colors.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getStatusWithCount()
    {
        $cases = AppointmentStatus::cases();

        return collect($cases)->map(function ($status) {
            return [
                'name' => $status->name,
                'value' => $status->value,
                'count' => Appointment::where('status', $status->value)->count(),
                'color' => AppointmentStatus::from($status->value)->color(),
            ];
        });
    }
}
