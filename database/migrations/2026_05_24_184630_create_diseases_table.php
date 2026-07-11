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
    Schema::create('diseases', function (Blueprint $table) {
        $table->id();

        $table->string('disease_name');
        $table->string('plant_name');

        $table->text('symptoms');
        $table->text('prevention');
        $table->string('medicine');

        $table->string('image')->nullable();

        $table->unsignedBigInteger('expert_id')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};
