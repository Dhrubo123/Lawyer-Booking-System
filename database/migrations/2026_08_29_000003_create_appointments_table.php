<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::create('appointments', function (Blueprint $table) { $table->id(); $table->string('appointment_no')->unique(); $table->foreignId('service_id')->constrained()->restrictOnDelete(); $table->string('client_name'); $table->string('client_phone'); $table->string('client_email')->nullable(); $table->string('consultation_type'); $table->date('appointment_date')->index(); $table->time('start_time'); $table->time('end_time'); $table->unsignedSmallInteger('duration'); $table->decimal('fee', 10, 2)->nullable(); $table->string('status')->default('pending')->index(); $table->text('client_message')->nullable(); $table->text('admin_note')->nullable(); $table->timestamps(); $table->index(['appointment_date', 'start_time']); }); }
    public function down(): void { Schema::dropIfExists('appointments'); }
};
