<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'short_description', 'duration', 'fee', 'is_active', 'sort_order'];
    protected function casts(): array { return ['is_active' => 'boolean', 'fee' => 'decimal:2']; }
}
