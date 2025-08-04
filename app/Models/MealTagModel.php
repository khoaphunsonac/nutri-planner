<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealTagModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meals_tags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'meal_id',
        'tag_id'
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function meal()
    {
        return $this->belongsTo(MealModel::class, 'meal_id');
    }

    public function tag()
    {
        return $this->belongsTo(TagModel::class, 'tag_id');
    }
}
