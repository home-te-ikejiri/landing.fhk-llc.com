<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReservationParticipant extends Model
{
    use HasFactory;

    protected $table = 'event_reservation_participants';
    protected $guarded = ['id'];

    public function reservation()
    {
        return $this->belongsTo(EventReservation::class, 'event_reservation_id');
    }
}
