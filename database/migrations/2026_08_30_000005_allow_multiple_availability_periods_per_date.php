<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('availability_dates', function (Blueprint $table) {
            $table->dropUnique('availability_dates_date_unique');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::table('availability_dates', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->unique('date');
        });
    }
};
