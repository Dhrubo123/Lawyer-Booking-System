<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class AvailabilitySchedule extends Model { protected $fillable = ['day_of_week', 'start_time', 'end_time', 'slot_duration', 'is_available']; protected function casts(): array { return ['is_available' => 'boolean']; } public function breaks(): HasMany { return $this->hasMany(AvailabilityBreak::class); } }
