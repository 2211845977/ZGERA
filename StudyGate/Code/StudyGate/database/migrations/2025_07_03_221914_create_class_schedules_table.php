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
        Schema::create('class_schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('subject_offer_id')->constrained('subject_offers')->cascadeOnDelete();
    $table->enum('day_of_week', ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']);
    $table->string('session',100);
    $table->string('room', 50);
    $table->timestamps();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
