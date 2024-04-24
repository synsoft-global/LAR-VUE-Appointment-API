<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a paginated list of appointments with client details.
     *
     * This method is responsible for retrieving a paginated list of appointments
     * from the database, along with associated client details. It optionally filters
     * the appointments by status if the 'status' query parameter is provided. The
     * appointments are sorted in descending order of creation and transformed into
     * a custom format suitable for display. The transformed data includes the appointment
     * ID, start time, end time, status (including color), and associated client details.
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Appointment::query()
            ->with('client:id,first_name,last_name')
            ->when(request('status'), function ($query) {
                return $query->where('status', AppointmentStatus::from(request('status')));
            })
            ->latest()
            ->paginate()
            ->through(fn ($appoinment) => [
                'id' => $appoinment->id,
                'start_time' => $appoinment->start_time->format('Y-m-d h:i A'),
                'end_time' => $appoinment->end_time->format('Y-m-d h:i A'),
                'status' => [
                    'name' => $appoinment->status->name,
                    'color' => $appoinment->status->color(),
                ],
                'client' => $appoinment->client,
            ]);
    }

    /**
     * Store a newly created appointment in the database.
     *
     * This method is responsible for validating and storing a new appointment
     * record in the database. It expects the following parameters in the request body:
     * - client_id: The ID of the client associated with the appointment (required).
     * - title: The title of the appointment (required).
     * - description: The description of the appointment (required).
     * - start_time: The start time of the appointment (required).
     * - end_time: The end time of the appointment (required).
     * 
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $validated = request()->validate([
            'client_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ], [
            'client_id.required' => 'The client name field is required.',
        ]);

        Appointment::create([
            'title' => $validated['title'],
            'client_id' => $validated['client_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'description' => $validated['description'],
            'status' => AppointmentStatus::SCHEDULED,
        ]);

        return response()->json(['message' => 'success']);
    }

    /**
     * Display the specified appointment for editing.
     *
     * This method is responsible for retrieving and displaying the specified
     * appointment for editing. It expects an Appointment model instance as a parameter,
     * which represents the appointment to be edited.
     * 
     * @param  Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        return $appointment;
    }

    /**
     * Update the specified appointment in the database.
     *
     * This method is responsible for validating and updating the specified appointment
     * in the database. It expects an Appointment model instance as a parameter, which
     * represents the appointment to be updated. It also expects the following parameters
     * in the request body:
     * - client_id: The ID of the client associated with the appointment (required).
     * - title: The title of the appointment (required).
     * - description: The description of the appointment (required).
     * - start_time: The start time of the appointment (required).
     * - end_time: The end time of the appointment (required).
     * 
     * @param  Appointment  $appointment
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Appointment $appointment)
    {
        $validated = request()->validate([
            'client_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ], [
            'client_id.required' => 'The client name field is required.',
        ]);

        $appointment->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified appointment from the database.
     *
     * This method is responsible for deleting the specified appointment
     * from the database. It expects an Appointment model instance as a
     * parameter, which represents the appointment to be deleted.
     * 
     * @param  Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['success' => true], 200);
    }
}
