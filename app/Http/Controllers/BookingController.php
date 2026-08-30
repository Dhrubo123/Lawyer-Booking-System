<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AvailabilityException;
use App\Models\AvailabilitySchedule;
use App\Models\AvailabilityDate;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('Public/BookAppointment', [
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->get(['id', 'name', 'short_description', 'duration', 'fee']),
            'confirmedAppointment' => $request->session()->get('appointment'),
            'branding' => ['logo_url' => Setting::valueFor('logo_url')],
            'availableDates' => $this->bookableDates(),
        ]);
    }

    public function slots(Request $request): JsonResponse
    {
        $data = $request->validate(['date' => ['required', 'date', 'after_or_equal:today']]);
        return response()->json(['date' => $data['date'], 'slots' => $this->availableSlots(Carbon::parse($data['date']))]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'consultation_type' => ['required', 'in:chamber,video,phone'],
            'service_id' => ['required', 'exists:services,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'client_name' => ['required', 'string', 'max:120'],
            'client_phone' => ['required', 'string', 'max:30'],
            'client_email' => ['nullable', 'email', 'max:120'],
            'client_message' => ['nullable', 'string', 'max:2000'],
        ]);

        $service = Service::query()->where('is_active', true)->findOrFail($data['service_id']);
        $date = Carbon::parse($data['appointment_date']);
        $slot = collect($this->availableSlots($date))->firstWhere('start_time', $data['start_time']);
        if (! $slot) throw ValidationException::withMessages(['start_time' => 'This time slot is no longer available. Please choose another time.']);
        $duration = Carbon::parse($date->toDateString().' '.$slot['start_time'])->diffInMinutes(Carbon::parse($date->toDateString().' '.$slot['end_time']));

        $appointment = DB::transaction(function () use ($data, $service, $slot, $duration) {
            $taken = Appointment::query()->where('appointment_date', $data['appointment_date'])->where('start_time', $slot['start_time'])->whereNotIn('status', ['cancelled'])->lockForUpdate()->exists();
            if ($taken) throw ValidationException::withMessages(['start_time' => 'This time slot is no longer available. Please choose another time.']);
            $client = Client::updateOrCreate(['phone' => $data['client_phone']], ['name' => $data['client_name'], 'email' => $data['client_email']]);
            $sequence = (Appointment::query()->lockForUpdate()->max('id') ?? 0) + 1;
            return Appointment::create([...$data, 'client_id' => $client->id, 'appointment_no' => 'TGS-'.now()->format('Y').'-'.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT), 'end_time' => $slot['end_time'], 'duration' => $duration, 'fee' => $service->fee, 'status' => 'pending']);
        });

        return to_route('book-appointment')->with('appointment', $appointment->only('appointment_no', 'appointment_date', 'start_time', 'consultation_type'));
    }

    private function availableSlots(Carbon $date, ?int $requestedDuration = null): array
    {
        $exception = AvailabilityException::query()->whereDate('date', $date)->first();
        if ($exception?->type === 'blocked' && is_null($exception->start_time)) return [];

        $specificSchedules = AvailabilityDate::query()
            ->whereDate('date', $date)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();

        // Specific dates take priority over the weekly schedule. A date may
        // have more than one non-overlapping availability period.
        if ($exception?->type === 'override') {
            $schedules = collect([$exception]);
        } elseif ($specificSchedules->isNotEmpty()) {
            $schedules = $specificSchedules;
        } else {
            $weeklySchedule = AvailabilitySchedule::query()->where('day_of_week', $date->dayOfWeek)->first();
            if (! $weeklySchedule || ! $weeklySchedule->is_available) return [];
            $schedules = collect([$weeklySchedule]);
        }

        $taken = Appointment::query()->whereDate('appointment_date', $date)->whereNotIn('status', ['cancelled'])->pluck('start_time')->map(fn ($time) => substr($time, 0, 5));
        $slots = [];
        foreach ($schedules as $schedule) {
            $duration = $requestedDuration ?? $schedule->slot_duration;
            $start = Carbon::parse($date->toDateString().' '.$schedule->start_time);
            $end = Carbon::parse($date->toDateString().' '.$schedule->end_time);
            $breaks = $schedule instanceof AvailabilitySchedule ? $schedule->breaks : collect();

            while ($start->copy()->addMinutes($duration)->lte($end)) {
                $slotEnd = $start->copy()->addMinutes($duration);
                $blocked = $exception?->type === 'blocked' && $exception->start_time && $start->format('H:i:s') < $exception->end_time && $slotEnd->format('H:i:s') > $exception->start_time;
                $inBreak = $breaks->contains(fn ($break) => $start->format('H:i:s') < $break->end_time && $slotEnd->format('H:i:s') > $break->start_time);
                if (! $blocked && ! $inBreak && ! $taken->contains($start->format('H:i'))) {
                    $slots[] = ['start_time' => $start->format('H:i'), 'end_time' => $slotEnd->format('H:i')];
                }
                $start->addMinutes($duration);
            }
        }

        return collect($slots)->unique('start_time')->sortBy('start_time')->values()->all();
    }

    private function bookableDates(): array
    {
        $specificDates = AvailabilityDate::query()->whereDate('date', '>=', today())->where('is_available', true)->orderBy('date')->get();
        if ($specificDates->isNotEmpty()) {
            return $specificDates
                ->groupBy(fn (AvailabilityDate $date) => $date->date->toDateString())
                ->map(function ($periods, string $date) {
                    $slots = $this->availableSlots(Carbon::parse($date));

                    return ['date' => $date, 'available_slots' => count($slots), 'slots' => $slots];
                })
                ->values()
                ->all();
        }
        return collect(range(0, 30))
            ->map(fn (int $offset) => today()->addDays($offset))
            ->map(function (Carbon $date) {
                $slots = $this->availableSlots($date);

                return ['date' => $date->toDateString(), 'available_slots' => count($slots), 'slots' => $slots];
            })
            ->filter(fn (array $date) => $date['available_slots'] > 0)
            ->take(12)
            ->values()
            ->all();
    }
}
