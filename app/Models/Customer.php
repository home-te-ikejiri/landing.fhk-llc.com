<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $guarded = ['id'];

    public function rentalRoomReservations()
    {
        return $this->hasMany(RentalRoomReservation::class);
    }

    public function eventReservations()
    {
        return $this->hasMany(EventReservation::class);
    }
}
