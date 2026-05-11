<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // ステータス
    const STATUS_DRAFT     = 0; // 非公開
    const STATUS_PUBLISHED = 1; // 公開
    const STATUS_ENDED     = 2; // 終了

    protected $table = 'events';
    protected $guarded = ['id'];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function reservations()
    {
        return $this->hasMany(EventReservation::class);
    }

    /**
     * 確定・仮予約の参加人数合計を返す
     */
    public function confirmedParticipantsCount(): int
    {
        return $this->reservations()
            ->whereIn('status', [EventReservation::STATUS_TENTATIVE, EventReservation::STATUS_CONFIRMED])
            ->sum('num_participants');
    }
}
