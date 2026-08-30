<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AvailabilityException extends Model { protected $fillable = ['date', 'type', 'start_time', 'end_time', 'reason']; protected function casts(): array { return ['date' => 'date']; } }
