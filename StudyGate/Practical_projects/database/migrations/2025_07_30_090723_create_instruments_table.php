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
    Schema::create('instruments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lab_id')->nullable(); // no FK for now
        $table->string('name');
        $table->string('purpose');
        $table->text('description');
        $table->string('serial_number')->unique();
        $table->string('model')->nullable();
        $table->text('experiment_types')->nullable();
        $table->text('analysis_types')->nullable();
        $table->enum('status', ['active', 'maintenance', 'out_of_order'])->default('active');
        $table->text('required_materials')->nullable();
        $table->string('responsible_person')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
