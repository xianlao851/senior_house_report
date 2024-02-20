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
        Schema::create('sho_mo_duties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sho_id');
            $table->string('emp_id', 100);
            $table->foreignId('department_id');
            $table->timestamp('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sho_mo_duties');
    }
};
