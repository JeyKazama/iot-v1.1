<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Devices', function (Blueprint $table) {
            $table->id();

            // Kolom device (boolean)
            $table->boolean('kipas')->default(false);
            $table->boolean('ac')->default(false);
            $table->boolean('air_purifier')->default(false);

            // Kolom LED
            $table->boolean('led1')->default(false);
            $table->boolean('led2')->default(false);
            $table->boolean('led3')->default(false);

            // Mode otomatis
            $table->boolean('kipas_auto')->default(true);
            $table->boolean('ac_auto')->default(true);
            $table->boolean('air_purifier_auto')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Devices');
    }
};
