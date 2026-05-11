<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // 関連種別
    const RELATED_TYPE_RENTAL_ROOM  = 'rental_room_reservation';
    const RELATED_TYPE_EVENT        = 'event_reservation';

    // ステータス
    const STATUS_PENDING    = 0; // 未対応
    const STATUS_IN_PROGRESS = 1; // 対応中
    const STATUS_DONE       = 2; // 完了

    protected $table = 'contacts';
    protected $guarded = ['id'];
}
