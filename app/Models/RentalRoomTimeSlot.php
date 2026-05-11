<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRoomTimeSlot extends Model
{
    use HasFactory;

    protected $table = 'rental_room_time_slots';
    protected $guarded = ['id'];

    protected $casts = [
        'date'       => 'date',
        'is_blocked' => 'boolean',
    ];
}
