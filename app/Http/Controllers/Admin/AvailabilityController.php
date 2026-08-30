<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AvailabilityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Availability', [
            'schedules' => AvailabilitySchedule::query()->orderBy('day_of_week')->get(),
        ]);
    }

    public function update(Request $request, AvailabilitySchedule $availabilitySchedule): RedirectResponse
    {
        $data = $this->validatedSchedule($request, $availabilitySchedule);
        $availabilitySchedule->update($data);
        return back()->with('success', 'Availability saved. New appointment slots now use this schedule.');
    }

    public function store(Request $request): RedirectResponse
    {
        AvailabilitySchedule::create($this->validatedSchedule($request));
        return back()->with('success', 'Availability day added.');
    }

    public function destroy(AvailabilitySchedule $availabilitySchedule): RedirectResponse
    {
        $availabilitySchedule->delete();
        return back()->with('success', 'Availability day removed. Clients can no longer book this day.');
    }

    private function validatedSchedule(Request $request, ?AvailabilitySchedule $schedule = null): array
    {
        return $request->validate([
            'day_of_week' => ['required', 'integer', 'between:0,6', Rule::unique('availability_schedules', 'day_of_week')->ignore($schedule)],
            'is_available' => ['required', 'boolean'],
            'start_time' => ['required_if:is_available,true', 'nullable', 'date_format:H:i'],
            'end_time' => ['required_if:is_available,true', 'nullable', 'date_format:H:i', 'after:start_time'],
            'slot_duration' => ['required_if:is_available,true', 'nullable', 'integer', 'min:15', 'max:180'],
        ]);
    }
}
