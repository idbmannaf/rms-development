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
        Schema::create('active_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('tower_id')->nullable();
            $table->string('chipid')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->string('device_name')->nullable();
            $table->boolean('voltage_phase_a')->default(0);
            $table->boolean('voltage_phase_b')->default(0);
            $table->boolean('voltage_phase_c')->default(0);
            $table->boolean('current_phase_a')->default(0);
            $table->boolean('current_phase_b')->default(0);
            $table->boolean('current_phase_c')->default(0);
            $table->boolean('frequency')->default(0);
            $table->boolean('power_factor')->default(0);
            $table->boolean('cumilative_energy')->default(0);
            $table->boolean('power')->default(0);
            $table->boolean('dc_voltage')->default(0);
            $table->boolean('tanent_load')->default(0);
            $table->boolean('cumilative_dc_energy')->default(0);
            $table->boolean('power_dc')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_devices');
    }
};
