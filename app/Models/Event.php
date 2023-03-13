<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'event_detail_id',
        'creator_user_id',
        'category_id',
        'is_liked',
    ];

    public function event_detail()
    {
        return $this->hasOne(EventDetail::class);
    }

    public function creator_user()
    {
        return $this->belongsToMany(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->HasMany(Comment::class);
    }

    public function event_medias(){
        return $this->belongsToMany(Media::class, 'rs_event_medias');
    }
}
