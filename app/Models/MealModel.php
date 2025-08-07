<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meals';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'diet_type_id',
        'meal_type_id',
        'preparation',
        'image_url',
        'description'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relationships
    public function dietType()
    {
        return $this->belongsToMany(DietTypeModel::class, 'diet_type_id' );
    }

    public function mealType()
    {
        return $this->belongsTo(MealTypeModel::class, 'meal_type_id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagModel::class, 'meals_tags', 'meal_id', 'tag_id')
            ->whereNull('meals_tags.deleted_at');
    }

    public function allergens()
    {
        return $this->belongsToMany(AllergenModel::class, 'meal_allergens', 'meal_id', 'allergen_id')
            ->whereNull('meal_allergens.deleted_at');
    }

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredientModel::class, 'meal_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(IngredientModel::class, 'recipe_ingredients', 'meal_id', 'ingredient_id')
            ->withPivot('quantity', 'total_calo')
            ->whereNull('recipe_ingredients.deleted_at');
    }

    // Calculate total calories for this meal
    public function getTotalCaloriesAttribute()
    {
        return $this->recipeIngredients->sum('total_calo');
    }

    // Get total nutrition for this meal
    public function getTotalNutritionAttribute()
    {
        $totalProtein = 0;
        $totalCarb = 0;
        $totalFat = 0;

        foreach ($this->recipeIngredients as $recipeIngredient) {
            if ($recipeIngredient->ingredient && $recipeIngredient->quantity) {
                $factor = $recipeIngredient->quantity / 100;
                $totalProtein += ($recipeIngredient->ingredient->protein ?? 0) * $factor;
                $totalCarb += ($recipeIngredient->ingredient->carb ?? 0) * $factor;
                $totalFat += ($recipeIngredient->ingredient->fat ?? 0) * $factor;
            }
        }

        return [
            'protein' => round($totalProtein, 2),
            'carb' => round($totalCarb, 2),
            'fat' => round($totalFat, 2),
            'calories' => round(($totalProtein * 4) + ($totalCarb * 4) + ($totalFat * 9), 2)
        ];
    }
}
