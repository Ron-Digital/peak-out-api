<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $table = 'event_details';

    protected $fillable = [
        'event_name',
        'description',
        'tags',
        'transport',
        'location',
        'materials',
        'latitude',
        'longitude',
        'price',
        'started_at'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
