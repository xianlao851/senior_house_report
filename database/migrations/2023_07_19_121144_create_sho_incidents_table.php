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
        Schema::create('sho_incidents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('incident_case_reported');
            $table->bigInteger('absconding_patient_case_reported');
            $table->bigInteger('doa_patient_case_reported');
            $table->bigInteger('other_security_function');
            $table->text('trauma_patient_case_reported');
            $table->foreignId('sho_id');
            $table->timestamp('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sho_incidents');
    }
};
