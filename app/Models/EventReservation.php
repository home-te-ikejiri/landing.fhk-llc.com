<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReservation extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_TENTATIVE  = 0; // 仮予約
    const STATUS_CONFIRMED  = 1; // 確定
    const STATUS_CANCELLED  = 2; // キャンセル

    protected $table = 'event_reservations';
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function participants()
    {
        return $this->hasMany(EventReservationParticipant::class)->orderBy('sort_order');
    }
}
