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
        Schema::create('exam_schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('subject_offer_id')->constrained('subject_offers')->cascadeOnDelete();
    $table->enum('exam_type', ['Midterm', 'Final']);
    $table->date('exam_date');
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
        Schema::dropIfExists('exam_schedules');
    }
};
