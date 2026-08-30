<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = ['appointment_no', 'client_id', 'service_id', 'client_name', 'client_phone', 'client_email', 'consultation_type', 'appointment_date', 'start_time', 'end_time', 'duration', 'fee', 'status', 'client_message', 'admin_note'];
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }
}
