<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sho_significant_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sho_id');
            $table->foreignId('patient_id');
            $table->string('nature_of_incident', 80);
            $table->string('place_of_incident', 80);
            $table->string('time_of_incident', 80);
            $table->string('date_of_incident', 20);
            $table->date('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sho_significant_events');
    }
};