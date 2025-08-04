<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngredientModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingredients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'unit',
        'protein',
        'carb',
        'fat',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Virtual attribute: calo = pro*4 + carb*4 + fat*9
    public function getCaloAttribute()
    {
        $protein = $this->protein ?? 0;
        $carb = $this->carb ?? 0;
        $fat = $this->fat ?? 0;
        return round(($protein * 4) + ($carb * 4) + ($fat * 9), 2);
    }

    // Relationships
    public function meals()
    {
        return $this->belongsToMany(MealModel::class, 'recipe_ingredients', 'ingredient_id', 'meal_id')
            ->withPivot('quantity', 'total_calo')
            ->whereNull('recipe_ingredients.deleted_at');
    }

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredientModel::class, 'ingredient_id');
    }
}
