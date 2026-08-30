<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySchedule;
use App\Models\AvailabilityDate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AvailabilityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Availability', [
            'schedules' => AvailabilitySchedule::query()->orderBy('day_of_week')->get(),
            'dates' => AvailabilityDate::query()->whereDate('date', '>=', today())->orderBy('date')->get(),
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

    public function storeDate(Request $request): RedirectResponse { AvailabilityDate::create($this->validatedDate($request)); return back()->with('success', 'Specific available date added.'); }
    public function updateDate(Request $request, AvailabilityDate $availabilityDate): RedirectResponse { $availabilityDate->update($this->validatedDate($request, $availabilityDate)); return back()->with('success', 'Specific available date updated.'); }
    public function destroyDate(AvailabilityDate $availabilityDate): RedirectResponse { $availabilityDate->delete(); return back()->with('success', 'Specific available date removed.'); }

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

    private function validatedDate(Request $request, ?AvailabilityDate $date = null): array
    {
        $data = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'is_available' => ['required', 'boolean'],
            'start_time' => ['required_if:is_available,true', 'nullable', 'date_format:H:i'],
            'end_time' => ['required_if:is_available,true', 'nullable', 'date_format:H:i', 'after:start_time'],
            'slot_duration' => ['required_if:is_available,true', 'nullable', 'integer', 'in:60,90,120,180'],
        ]);

        // Several separate periods may be published for one day, but periods
        // must not overlap or one lawyer could be double-booked.
        $overlaps = AvailabilityDate::query()
            ->whereDate('date', $data['date'])
            ->when($date, fn ($query) => $query->where('id', '!=', $date->getKey()))
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->exists();

        if ($overlaps) {
            throw ValidationException::withMessages([
                'start_time' => 'This time overlaps an existing period for the selected date.',
            ]);
        }

        return $data;
    }
}
