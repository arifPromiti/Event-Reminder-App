<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_id',
        'title',
        'details',
        'event_date_time',
        'status',
    ];

    public function eventGuest(){
        return $this->hasMany(EventGuest::class, 'event_id', 'id');
    }
}
