<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieProduct extends Model
{
    use HasFactory;

    protected $table = 'calorie_products';

    protected $fillable = ['name', 'unit', 'proteins', 'fats', 'carbohydrates', 'calories'];
}
