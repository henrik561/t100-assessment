<?php

use App\Enums\TransportationMethods;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // cant seem to fix TransportationMethods::toArray() or ::cases(), this returns an empty array for some reason, so a manual array is used instead // TODO: optimize this
            $table->enum('transportation_method', [TransportationMethods::BIKE, TransportationMethods::CAR, TransportationMethods::BUS, TransportationMethods::TRAIN]);
            $table->integer('distance');
            $table->integer('workdays_per_week');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
