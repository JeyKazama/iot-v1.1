<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('smarthomes', function (Blueprint $table) {
        $table->id();
        $table->boolean('lampu_tidur')->default(false);
        $table->boolean('ac')->default(false);
        $table->boolean('wifi')->default(false);
        $table->boolean('tv')->default(false);
        $table->boolean('smart_plug')->default(false);
        $table->boolean('smart_lock')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smarthomes');
    }
};
