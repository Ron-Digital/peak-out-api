<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'author_user_id',
        'event_id',
        'comment_text',
        'rate'
    ];

    public function author_user()
    {
        return $this->belongsToMany(User::class);
    }

    public function comments_event()
    {
        return $this->belongsTo(Event::class);
    }
}
