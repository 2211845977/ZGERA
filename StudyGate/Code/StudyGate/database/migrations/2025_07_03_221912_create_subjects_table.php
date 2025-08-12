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
    Schema::create('subjects', function (Blueprint $table) {
        $table->id();
        $table->string('name', 100);
        $table->foreignId('prerequisite_subject_id')->nullable()->constrained('subjects')->nullOnDelete();
        $table->string('semester')->nullable();
        $table->integer('units')->default(3); 
        $table->timestamps(); 
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
