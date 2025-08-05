<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {


            $table->id();
            // name به عنوان کلید اصلی متنی با طول محدود
            $table->string('name', 30);

            // تاریخ، datetime و NOT NULL
            $table->dateTime('date');

            // توضیح: متن بزرگ (nullable چون نگفتی حتماً پر باشه)
            $table->text('description')->nullable();

            // عدد غذا (مثلاً شماره یا شناسه عددی)، NOT NULL
            $table->integer('food_id');

            // اگر خواستی زمان ایجاد/آپدیت داشته باشی (اختیاری)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
