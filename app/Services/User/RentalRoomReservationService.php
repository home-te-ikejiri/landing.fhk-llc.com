<?php

namespace App\Services\User;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\RentalRoomReservation;
use App\Models\RentalRoomSchedule;
use App\Models\RentalRoomSetting;
use App\Models\RentalRoomTimeSlot;
use App\Models\Customer;
use App\Mail\RentalRoomReservationMail;
use App\Mail\RentalRoomReservationConfirmMail;
use Illuminate\Support\Facades\Mail;

class RentalRoomReservationService
{
    const HOURS = [10, 11, 12, 13, 14, 15, 16, 17];

    /**
     * 日付の時間帯一覧と空き状況を返す
     *
     * @param  string $dateStr  'Y-m-d' 形式
     * @return array{
     *     date: Carbon,
     *     rental_schedule: RentalRoomSchedule|null,
     *     hours: array<int, array{hour: int, label: string, status: string, remaining: int}>,
     *     capacity: int
     * }|null  営業日でない場合は null
     */
    public function getTimeSlots(string $dateStr): ?array
    {
        $date = Carbon::parse($dateStr);

        $schedule = RentalRoomSchedule::where('date', $dateStr)->first();

        // 営業日（status=2:営業）以外はアクセス不可
        if (!$schedule || $schedule->status !== RentalRoomSchedule::STATUS_OPEN) {
            return null;
        }

        $capacity = RentalRoomSetting::first()?->capacity ?? 3;

        // 管理者ブロック枠
        $blocked = RentalRoomTimeSlot::where('date', $dateStr)
            ->where('is_blocked', 1)
            ->pluck('hour')->toArray();

        // 公開中イベント
        $events = Event::where('event_date', $dateStr)
            ->where('status', Event::STATUS_PUBLISHED)
            ->get();

        // 有効な予約（仮予約・確定済み）
        $reservations = RentalRoomReservation::where('reservation_date', $dateStr)
            ->whereIn('status', [
                RentalRoomReservation::STATUS_TENTATIVE,
                RentalRoomReservation::STATUS_CONFIRMED,
            ])->get();

        $hours = [];
        foreach (self::HOURS as $h) {
            $status    = 'available'; // available / blocked
            $remaining = $capacity;

            // 1. 管理者都合ブロック
            if (in_array($h, $blocked)) {
                $status = 'blocked';
            }

            // 2. イベント貸し切り
            if ($status === 'available') {
                foreach ($events as $ev) {
                    $sh = (int) substr($ev->start_time, 0, 2);
                    $eh = (int) substr($ev->end_time,   0, 2);
                    if ($sh <= $h && $h < $eh) {
                        $status = 'blocked';
                        break;
                    }
                }
            }

            // この時間帯と重なる有効予約を抽出
            $slotReservations = $reservations->filter(function ($r) use ($h) {
                $sh = (int) substr($r->start_time, 0, 2);
                $eh = (int) substr($r->end_time,   0, 2);
                return $sh <= $h && $h < $eh;
            });

            // 3. 占有予約によるブロック（占有が1件でもあれば全席ブロック）
            if ($status === 'available' && $slotReservations->where('usage_type', RentalRoomReservation::USAGE_TYPE_EXCLUSIVE)->isNotEmpty()) {
                $status    = 'blocked';
                $remaining = 0;
            }

            // 4. 席数上限（共有予約の合計が定員以上）
            if ($status === 'available') {
                $used      = $slotReservations->sum('num_people');
                $remaining = $capacity - $used;
                if ($remaining <= 0) {
                    $status    = 'blocked';
                    $remaining = 0;
                }
            }

            $hours[] = [
                'hour'            => $h,
                'label'           => sprintf('%02d:00〜%02d:00', $h, $h + 1),
                'status'          => $status,
                'remaining'       => $status === 'available' ? $remaining : 0,
                'has_reservation' => $slotReservations->isNotEmpty(),
            ];
        }

        return [
            'date'             => $date,
            'rental_schedule'  => $schedule,
            'hours'            => $hours,
            'capacity'         => $capacity,
        ];
    }

    /**
     * 予約を保存する（仮予約として登録）
     */
    public function save(array $data): RentalRoomReservation
    {
        // 顧客情報 upsert
        $customer = Customer::updateOrCreate(
            ['email' => $data['email']],
            ['name'  => $data['name'], 'phone' => $data['phone']]
        );

        $reservation = RentalRoomReservation::create([
            'customer_id'      => $customer->id,
            'reservation_date' => $data['reservation_date'],
            'start_time'       => $data['start_time'] . ':00:00',
            'end_time'         => $data['end_time']   . ':00:00',
            'usage_type'       => $data['usage_type'],
            'purpose'          => $data['purpose'],
            'num_people'       => $data['num_people'],
            'name'             => $data['name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'message'          => $data['message'] ?? null,
            'status'           => RentalRoomReservation::STATUS_TENTATIVE,
        ]);

        // 管理者への通知メール
        $adminTo = config('mail.contact_to', config('mail.from.address'));
        Mail::to($adminTo)->send(new RentalRoomReservationMail($reservation));

        // 予約者への確認メール
        Mail::to($data['email'])->send(new RentalRoomReservationConfirmMail($reservation));

        return $reservation;
    }
}
