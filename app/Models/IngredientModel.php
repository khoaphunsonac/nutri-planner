<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientModel extends Model
{
    use SoftDeletes;
    protected $table = 'ingredients';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'unit',
        'protein',
        'carb',
        'fat',
    ];

    // Virtual attribute: calo = pro*4 + carb*4 + fat*9
    public function getCaloAttribute()
    {
        $protein = $this->protein ?? 0;
        $carb = $this->carb ?? 0;
        $fat = $this->fat ?? 0;
        return round(($protein * 4) + ($carb * 4) + ($fat * 9), 2);
    }

    public function meals()
    {
        // return $this->belongsToMany(MealModel::class, 'ingredient_meal', 'ingredient_id', 'meal_id');
    }
}
