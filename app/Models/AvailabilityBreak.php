<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AvailabilityBreak extends Model { protected $fillable = ['availability_schedule_id', 'start_time', 'end_time']; }
