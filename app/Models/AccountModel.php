<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class AccountModel extends Model
{
    // use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;

    protected $table = 'accounts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role', 
    ];
    // date
    protected $CREATED_AT = 'created_at';
    protected $UPDATED_AT = 'updated_at';

   
}
