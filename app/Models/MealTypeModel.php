<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealTypeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meal_type';
    protected $primaryKey = 'id';

    // Bật timestamps để Laravel tự set created_at / updated_at
    public $timestamps = true;

    protected $fillable = ['name'];

    // Giữ theo code cũ
    protected $dates = ['deleted_at'];

    // Ép kiểu ngày giờ (format trong Blade dùng ->format() / ->translatedFormat())
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Quan hệ: 1 loại bữa ăn có nhiều món
    public function meals()
    {
        // foreignKey = meal_type_id, localKey = id
        return $this->hasMany(MealModel::class, 'meal_type_id', 'id');
    }
}
