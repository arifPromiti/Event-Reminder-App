<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_email',
        'guest_name',
        'event_id',
        'status',
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
