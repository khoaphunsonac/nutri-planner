<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllergenModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'allergens';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relationships
    public function meals()
    {
        return $this->belongsToMany(MealModel::class, 'meal_allergens', 'allergen_id', 'meal_id')
            ->whereNull('meal_allergens.deleted_at');
    }

    public function users()
    {
        return $this->belongsToMany(AccountModel::class, 'user_allergens', 'allergen_id', 'user_id')
            ->whereNull('user_allergens.deleted_at');
    }
}
