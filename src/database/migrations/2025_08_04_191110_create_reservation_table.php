<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->Integer('user_id')->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->default(1)->constrained('foods')->cascadeOnDelete();
            $table->dateTime('reservation_date');
            $table->boolean('eaten')->default(false);
            $table->timestamps();
            $table->primary(['user_id', 'food_id', 'reservation_date']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
