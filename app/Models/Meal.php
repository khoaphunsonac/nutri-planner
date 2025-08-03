<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Meal extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = 'meals';
    protected $primaryKey = 'id';
    protected $fillable=['name','diet_type_id','meal_type_id','preparation','image_url','description','created_at','updated_at','deleted_at'];
    // const CREATED_AT = 'created_at';
    const UPDATED_AT = NULL;
    const DELETED_AT= 'deleted_at';

   
    
}
