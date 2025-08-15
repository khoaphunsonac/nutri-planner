<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AccountModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'accounts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'note',
        'savemeal',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Relationships
    public function allergens()
    {
        return $this->belongsToMany(AllergenModel::class, 'user_allergens', 'user_id', 'allergen_id')
            ->whereNull('user_allergens.deleted_at');
    }

    public function feedback()
    {
        return $this->hasMany(FeedbackModel::class, 'account_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role,
            'username' => $this->username,
            'email' => $this->email
        ];
    }




    public function getSavemealPreviewAttribute()
{
    if (empty($this->savemeal)) {
        return [];
    }

    // Tách chuỗi "18-17-15-10" thành mảng ID
    $mealIds = explode('-', $this->savemeal);

    // Lấy danh sách meal theo ID, giữ đúng thứ tự
    $meals = \App\Models\MealModel::whereIn('id', $mealIds)->get();

    $result = [];
    $count = 0;
    foreach ($meals as $meal) {
        if ($count < 2) { // chỉ lấy 2 món đầu
            $result[] = $meal;
        }
        $count++;
    }

    // Nếu nhiều hơn 2 thì thêm dấu "..."
    if ($count > 3) {
        $result[] = (object) ['name' => '...'];
    }

    return $result;
}
}
