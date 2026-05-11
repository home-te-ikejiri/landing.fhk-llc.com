<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRoomReservation extends Model
{
    use HasFactory;

    // 利用種別
    const USAGE_TYPE_SHARED    = 0; // 共有（席のみ）
    const USAGE_TYPE_EXCLUSIVE = 1; // 占有（フロア貸し切り）

    // 利用目的
    const PURPOSE_MEETING  = 0; // 打ち合わせ
    const PURPOSE_SEMINAR  = 1; // セミナー
    const PURPOSE_EVENT    = 2; // イベント
    const PURPOSE_SEAT     = 3; // 席利用
    const PURPOSE_OTHER    = 4; // その他

    // ステータス
    const STATUS_TENTATIVE    = 0; // 仮予約
    const STATUS_CONFIRMED    = 1; // 確定
    const STATUS_REJECTED     = 2; // 受付不可
    const STATUS_CANCELLED    = 3; // キャンセル

    protected $table = 'rental_room_reservations';
    protected $guarded = ['id'];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
