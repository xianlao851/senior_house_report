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
        Schema::create('sho_transfer_tos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id');
            $table->foreignId('hospital_id');
            $table->foreignId('sho_id');
            $table->text('diagnosis');
            $table->text('reason');
            $table->date('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sho_transfer_tos');
    }
};
