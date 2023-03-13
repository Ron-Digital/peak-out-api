<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'title',
        'description',
    ];

    public function category_events()
    {
        return $this->hasMany(Event::class);
    }

    public function user_categories()
    {
        return $this->belongsToMany(User::class);
    }
}
