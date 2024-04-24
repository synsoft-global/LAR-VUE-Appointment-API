<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;

class DashboardStatController extends Controller
{
    /**
     * Retrieve total appointments count based on status.
     *
     * This method is responsible for retrieving the total count of appointments
     * based on the specified status. It optionally filters appointments by status
     * using the 'status' query parameter and returns the total count of appointments
     * for each status. If no status is specified, it returns the total count of all
     * appointments.
     * 
     * @return \Illuminate\Http\Response
     */
    public function appointments()
    {
        $totalAppointmentsCount = Appointment::query()
            ->when(request('status') === 'scheduled', function ($query) {
                $query->where('status', AppointmentStatus::SCHEDULED);
            })
            ->when(request('status') === 'confirmed', function ($query) {
                $query->where('status', AppointmentStatus::CONFIRMED);
            })
            ->when(request('status') === 'cancelled', function ($query) {
                $query->where('status', AppointmentStatus::CANCELLED);
            })
            ->count();

        return response()->json([
            'totalAppointmentsCount' => $totalAppointmentsCount,
        ]);
    }

    /**
     * Retrieve total users count based on date range.
     *
     * This method is responsible for retrieving the total count of users
     * based on the specified date range. It optionally filters users by
     * date range using the 'date_range' query parameter and returns the
     * total count of users for each date range.
     * 
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $totalUsersCount = User::query()
            ->when(request('date_range') === 'today', function ($query) {
                $query->whereBetween('created_at', [now()->today(), now()]);
            })
            ->when(request('date_range') === '30_days', function ($query) {
                $query->whereBetween('created_at', [now()->subDays(30), now()]);
            })
            ->when(request('date_range') === '60_days', function ($query) {
                $query->whereBetween('created_at', [now()->subDays(60), now()]);
            })
            ->when(request('date_range') === '360_days', function ($query) {
                $query->whereBetween('created_at', [now()->subDays(360), now()]);
            })
            ->when(request('date_range') === 'month_to_date', function ($query) {
                $query->whereBetween('created_at', [now()->firstOfMonth(), now()]);
            })
            ->when(request('date_range') === 'year_to_date', function ($query) {
                $query->whereBetween('created_at', [now()->firstOfYear(), now()]);
            })
            ->count();

        return response()->json([
            'totalUsersCount' => $totalUsersCount,
        ]);
    }
}
