<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tags';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at','updated_at', 'created_at'];

    // Relationship with meals
    public function meals()
    {
        return $this->belongsToMany(MealModel::class, 'meals_tags', 'tag_id', 'meal_id')
            ->whereNull('meals_tags.deleted_at');
    }
}
