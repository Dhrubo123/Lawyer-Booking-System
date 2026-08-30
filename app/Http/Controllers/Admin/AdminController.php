<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function login(): Response { return Inertia::render('Admin/Login'); }

    public function dashboard(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                ['label' => "Today's appointments", 'value' => Appointment::whereDate('appointment_date', today())->count(), 'tone' => 'orange'],
                ['label' => 'Upcoming', 'value' => Appointment::whereDate('appointment_date', '>', today())->whereIn('status', ['pending', 'confirmed'])->count(), 'tone' => 'dark'],
                ['label' => 'Pending', 'value' => Appointment::where('status', 'pending')->count(), 'tone' => 'cream'],
                ['label' => 'Confirmed', 'value' => Appointment::where('status', 'confirmed')->count(), 'tone' => 'sage'],
            ],
            'todayAppointments' => Appointment::with('service')->whereDate('appointment_date', today())->orderBy('start_time')->get(),
        ]);
    }

    public function appointments(): Response { return Inertia::render('Admin/Appointments', ['appointments' => Appointment::with('service')->latest('appointment_date')->paginate(15)]); }
    public function showAppointment(Appointment $appointment): Response { return Inertia::render('Admin/AppointmentDetail', ['appointment' => $appointment->load('service')]); }
    public function updateAppointmentStatus(Request $request, Appointment $appointment): RedirectResponse { $data = $request->validate(['status' => ['required', 'in:pending,confirmed,completed,cancelled,no_show']]); $appointment->update($data); return back()->with('success', 'Appointment status updated.'); }
    public function calendar(): Response { return Inertia::render('Admin/Placeholder', ['title' => 'Calendar', 'description' => 'A clear view of your consultation schedule.']); }
    public function availability(): Response { return Inertia::render('Admin/Placeholder', ['title' => 'Availability', 'description' => 'Set weekly hours, breaks, and date-specific availability.']); }
    public function clients(): Response { return Inertia::render('Admin/Placeholder', ['title' => 'Clients', 'description' => 'Keep every client and consultation history in one place.']); }
    public function services(): Response { return Inertia::render('Admin/Placeholder', ['title' => 'Services', 'description' => 'Manage the services clients can book online.', 'services' => Service::orderBy('sort_order')->get()]); }
    public function insights(): Response { return Inertia::render('Admin/Placeholder', ['title' => 'Tax insights', 'description' => 'Create and publish useful tax and legal guidance.']); }
    public function settings(): Response { return Inertia::render('Admin/Placeholder', ['title' => 'Settings', 'description' => 'Manage business, lawyer, and appointment details.']); }
}
