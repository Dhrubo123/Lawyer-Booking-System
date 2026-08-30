<?php

namespace Database\Seeders;

use App\Models\AvailabilitySchedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@taxgeneral.test'], ['name' => 'Administrator', 'password' => Hash::make('password'), 'is_admin' => true]);
        foreach (['Income Tax Consultation', 'VAT & Compliance', 'Tax Assessment & Appeal', 'Corporate Tax Advisory', 'Tax Notice Response', 'Tax Planning', 'General Consultation'] as $index => $name) {
            Service::updateOrCreate(['slug' => str($name)->slug()], ['name' => $name, 'duration' => 30, 'is_active' => true, 'sort_order' => $index + 1]);
        }
        foreach (range(0, 4) as $day) AvailabilitySchedule::updateOrCreate(['day_of_week' => $day], ['start_time' => '09:00', 'end_time' => '17:00', 'slot_duration' => 30, 'is_available' => true]);
    }
}
