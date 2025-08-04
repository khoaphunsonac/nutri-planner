<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DietTypeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diet_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relationships
    public function meals()
    {
        return $this->hasMany(MealModel::class, 'diet_type_id');
    }
}
