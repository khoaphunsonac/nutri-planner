<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AccountModel extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'accounts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relationships
    public function allergens()
    {
        return $this->belongsToMany(AllergenModel::class, 'user_allergens', 'user_id', 'allergen_id')
            ->whereNull('user_allergens.deleted_at');
    }

    public function feedback()
    {
        return $this->hasMany(FeedbackModel::class, 'user_id');
    }
}
