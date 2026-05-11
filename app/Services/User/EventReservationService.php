<?php

namespace App\Services\User;

use App\Models\Customer;
use App\Models\Event;
use App\Models\EventReservation;
use App\Models\EventReservationParticipant;
use App\Mail\EventReservationMail;
use App\Mail\EventReservationConfirmMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventReservationService
{
    /**
     * 公開中のイベントを取得し残席数を付加して返す
     *
     * @return Event|null  公開中でなければ null
     */
    public function getEvent(int $id): ?Event
    {
        $event = Event::find($id);

        if (!$event || $event->status !== Event::STATUS_PUBLISHED) {
            return null;
        }

        return $event;
    }

    /**
     * 現在の仮予約・確定済み参加人数合計を返す
     */
    public function reservedCount(Event $event): int
    {
        return $event->reservations()
            ->whereIn('status', [
                EventReservation::STATUS_TENTATIVE,
                EventReservation::STATUS_CONFIRMED,
            ])->sum('num_participants');
    }

    /**
     * 予約を保存する（仮予約として登録）
     *
     * @param  array $data  フォームデータ（participants は ['name'=>..., 'sort_order'=>...] の配列）
     */
    public function save(array $data): EventReservation
    {
        DB::beginTransaction();

        try {
            // 顧客 upsert
            $customer = Customer::updateOrCreate(
                ['email' => $data['email']],
                ['name' => $data['representative_name'], 'phone' => $data['representative_phone']]
            );

            // 予約本体
            $reservation = EventReservation::create([
                'event_id'             => $data['event_id'],
                'customer_id'          => $customer->id,
                'num_participants'     => $data['num_participants'],
                'representative_name'  => $data['representative_name'],
                'representative_phone' => $data['representative_phone'],
                'email'                => $data['email'],
                'message'              => $data['message'] ?? null,
                'status'               => EventReservation::STATUS_TENTATIVE,
            ]);

            // 参加者リスト
            $participants = $data['participants'] ?? [];
            foreach ($participants as $i => $name) {
                if ($name === null || $name === '') {
                    continue;
                }
                EventReservationParticipant::create([
                    'event_reservation_id' => $reservation->id,
                    'name'                 => $name,
                    'sort_order'           => $i,
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        // リレーションをロードしてからメール送信
        $reservation->load(['event', 'participants']);

        // 管理者への通知メール
        $adminTo = config('mail.contact_to', config('mail.from.address'));
        Mail::to($adminTo)->send(new EventReservationMail($reservation));

        // 申込者への確認メール
        Mail::to($data['email'])->send(new EventReservationConfirmMail($reservation));

        return $reservation;
    }
}
