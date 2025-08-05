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
        Schema::create('users', function (Blueprint $table) {

            
            $table->id();

            // Name و Last Name
            $table->string('name');
            $table->string('last_name');

            // Username (می‌تونی unique هم بذاری که تکراری نشه)
            $table->string('username')->unique();

            // Password
            $table->string('password');

            // زمان ایجاد و آپدیت
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
