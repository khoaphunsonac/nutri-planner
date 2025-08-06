<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealAllergenModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meal_allergens';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'meal_id',
        'allergen_id'
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function meal()
    {
        return $this->belongsTo(MealModel::class, 'meal_id');
    }

    public function allergen()
    {
        return $this->belongsTo(AllergenModel::class, 'allergen_id');
    }
}
