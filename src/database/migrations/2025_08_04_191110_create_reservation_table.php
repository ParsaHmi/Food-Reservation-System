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
        Schema::create('reservation', function (Blueprint $table) {

            

            // اگر بخوای خودت شناسه داشته باشی، از این استفاده نکن:
            // $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // به users.id
            $table->foreignId('food_id')->default(1)->constrained('foods')->cascadeOnDelete(); // به foods.id
            $table->dateTime('reservation_date'); // تاریخ رزرو
            $table->boolean('eaten')->default(false);
            $table->timestamps();

            // کلید ترکیبی برای جلوگیری از رزرو تکراری همان کاربر برای همان غذا در همان تاریخ
            $table->primary(['user_id', 'food_id', 'reservation_date']);



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation');
    }
};
