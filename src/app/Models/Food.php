<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // مشخص کردن نام جدول
    protected $table = 'foods';

    // فیلدهای قابل پر شدن
    protected $fillable = [
        'name',
        'date', 
        'description',
        'food_id'
    ];

    // اگر می‌خواهید از food_id به عنوان کلید اصلی استفاده کنید
    // protected $primaryKey = 'food_id';
}