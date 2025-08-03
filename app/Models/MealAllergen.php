<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MealAllergen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = 'meal_allergens';
    protected $primaryKey = 'id';
    protected $fillable=['name','deleted_at'];
    // const CREATED_AT = 'created_at';
    const UPDATED_AT = NULL;
    const DELETED_AT= 'deleted_at';

    public $timestamps = false; 
    
    public function meals(){
        return $this->belongsTo(Meal::class,'meal_id');
    }

     public function allergens(){
        return $this->belongsTo(Allergen::class,'allergen_id');
    }
    
}
