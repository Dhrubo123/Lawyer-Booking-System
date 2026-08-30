<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilityDate extends Model
{
    protected $fillable = ['date', 'start_time', 'end_time', 'slot_duration', 'is_available'];
    protected function casts(): array { return ['date' => 'date', 'is_available' => 'boolean']; }
}
