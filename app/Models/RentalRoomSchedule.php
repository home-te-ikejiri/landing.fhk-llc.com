<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRoomSchedule extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_UNREGISTERED = 0; // 未登録
    const STATUS_CLOSED       = 1; // 店休日
    const STATUS_OPEN         = 2; // 営業

    protected $table = 'rental_room_schedules';
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];
}
