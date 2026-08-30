<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::create('availability_dates', function (Blueprint $table) { $table->id(); $table->date('date')->unique(); $table->time('start_time'); $table->time('end_time'); $table->unsignedSmallInteger('slot_duration')->default(60); $table->boolean('is_available')->default(true); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('availability_dates'); }
};
