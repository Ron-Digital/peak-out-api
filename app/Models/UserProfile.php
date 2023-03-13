<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_name',
        'status',
        'biography',
        'average_rate',
        'phone_number',
        'gender',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
