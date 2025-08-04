<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeIngredientModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recipe_ingredients';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'meal_id',
        'ingredient_id',
        'quantity',
        'total_calo'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'quantity' => 'float',
        'total_calo' => 'float',
    ];

    // Relationships
    public function meal()
    {
        return $this->belongsTo(MealModel::class, 'meal_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(IngredientModel::class, 'ingredient_id');
    }

    // Calculate total calories based on ingredient nutrition and quantity
    public function calculateTotalCalo()
    {
        if ($this->ingredient && $this->quantity) {
            $ingredient = $this->ingredient;
            $protein = ($ingredient->protein ?? 0) * $this->quantity / 100;
            $carb = ($ingredient->carb ?? 0) * $this->quantity / 100;
            $fat = ($ingredient->fat ?? 0) * $this->quantity / 100;

            return round(($protein * 4) + ($carb * 4) + ($fat * 9), 2);
        }
        return 0;
    }
}
