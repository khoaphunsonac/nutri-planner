<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedback';
    protected $primaryKey = 'id';

    protected $fillable = [
        'account_id',
        'rating',
        'comment'
    ];

    protected $dates = ['created_at', 'deleted_at'];

    const UPDATED_AT = null; // No updated_at column

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function account()
    {
        return $this->belongsTo(AccountModel::class, 'account_id');
    }

    // Validation rules for rating
    public function getRatingTextAttribute()
    {
        $ratings = [
            1 => 'Rất tệ',
            2 => 'Tệ',
            3 => 'Trung bình',
            4 => 'Tốt',
            5 => 'Rất tốt'
        ];

        return $ratings[$this->rating] ?? 'Không xác định';
    }
}
