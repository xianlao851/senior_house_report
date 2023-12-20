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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();;
            $table->string('last_name');
            $table->string('age');
            $table->string('gender');
            $table->string('suffix')->nullable();;
            $table->string('preffix')->nullable();;
            $table->string('alias')->nullable();;
            $table->string('birth_date');
            $table->foreignId('patient_address_id');
            $table->string('contact_no');
            $table->string('birth_place');
            $table->string('civil_stat');
            $table->string('emp_stat');
            $table->string('ethnicity')->nullable();;
            $table->string('nationality');
            $table->string('religion')->nullable();;
            $table->string('blood_type');
            $table->string('entry_by');
            $table->string('record_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
