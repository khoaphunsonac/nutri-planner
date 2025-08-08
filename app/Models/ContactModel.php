<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'message'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}

