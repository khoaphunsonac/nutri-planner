<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAllergenModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_allergens';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'account_id',
        'meal_id'
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function account()
    {
        return $this->belongsTo(AccountModel::class, 'account_id');
    }

    public function meal()
    {
        return $this->belongsTo(MealModel::class, 'meal_id');
    }
}
