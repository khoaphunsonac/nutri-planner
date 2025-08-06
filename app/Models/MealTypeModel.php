<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealTypeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meal_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at'];

    // Relationship with meals
    public function meals()
    {
        return $this->hasMany(MealModel::class, 'meal_type_id');
    }
}
