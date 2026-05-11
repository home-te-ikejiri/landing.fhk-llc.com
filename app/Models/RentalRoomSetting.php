<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRoomSetting extends Model
{
    use HasFactory;

    protected $table = 'rental_room_settings';
    protected $guarded = ['id'];
}
