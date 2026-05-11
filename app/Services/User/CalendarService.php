<?php

namespace App\Services\User;

use Carbon\Carbon;
use App\Models\ShopSchedule;
use App\Models\RentalRoomSchedule;
use App\Models\RentalRoomTimeSlot;
use App\Models\RentalRoomReservation;
use App\Models\RentalRoomSetting;
use App\Models\Event;

class CalendarService
{
    /**
     * 月別カレンダーデータを返す
     *
     * @param  string $month  'YYYY-MM' 形式
     * @return array
     */
    public function getCalendar(string $month): array
    {
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        // 月内データ一括取得
        $shopSchedules = ShopSchedule::whereBetween('date', [$start->toDateString(), $end->toDateString()])
                            ->get()->keyBy(fn($r) => $r->date->format('Y-m-d'));

        $rentalSchedules = RentalRoomSchedule::whereBetween('date', [$start->toDateString(), $end->toDateString()])
                              ->get()->keyBy(fn($r) => $r->date->format('Y-m-d'));

        $blockedSlots = RentalRoomTimeSlot::whereBetween('date', [$start->toDateString(), $end->toDateString()])
                            ->where('is_blocked', 1)->get()
                            ->groupBy(fn($r) => $r->date->format('Y-m-d'));

        $events = Event::whereBetween('event_date', [$start->toDateString(), $end->toDateString()])
                      ->where('status', Event::STATUS_PUBLISHED)->get()
                      ->groupBy(fn($r) => $r->event_date->format('Y-m-d'));

        $reservations = RentalRoomReservation::whereBetween('reservation_date', [$start->toDateString(), $end->toDateString()])
                            ->whereIn('status', [
                                RentalRoomReservation::STATUS_TENTATIVE,
                                RentalRoomReservation::STATUS_CONFIRMED,
                            ])->get()
                            ->groupBy(fn($r) => $r->reservation_date->format('Y-m-d'));

        $capacity = RentalRoomSetting::first()?->capacity ?? 3;

        // 日別データ構築
        $days = [];
        $cur  = $start->copy();
        while ($cur->lte($end)) {
            $ds         = $cur->format('Y-m-d');
            $dayEvents  = $events->get($ds, collect());
            $dayBlocked = $blockedSlots->get($ds, collect());
            $dayRes     = $reservations->get($ds, collect());

            $shopRec   = $shopSchedules->get($ds);
            $rentalRec = $rentalSchedules->get($ds);

            $shopStatus   = $shopRec?->status   ?? ShopSchedule::STATUS_UNREGISTERED;
            $rentalStatus = $rentalRec?->status ?? RentalRoomSchedule::STATUS_UNREGISTERED;

            $rentalAvailable = null;
            if ($rentalStatus === RentalRoomSchedule::STATUS_OPEN) {
                $rentalAvailable = $this->isDayAvailable($dayBlocked, $dayEvents, $dayRes, $capacity);
            }

            $days[] = [
                'date'             => $cur->copy(),
                'date_str'         => $ds,
                'dow'              => $cur->dayOfWeek, // 0=日…6=土
                'shop_status'      => $shopStatus,
                'rental_status'    => $rentalStatus,
                'rental_available' => $rentalAvailable, // true/false/null
                'events'           => $dayEvents,
            ];

            $cur->addDay();
        }

        // 週ごとにグループ化（先頭を日曜基準で null パディング）
        $weeks = [];
        $week  = array_fill(0, $days[0]['dow'], null);
        foreach ($days as $day) {
            $week[] = $day;
            if (count($week) === 7) {
                $weeks[] = $week;
                $week    = [];
            }
        }
        if (!empty($week)) {
            $weeks[] = array_pad($week, 7, null);
        }

        return [
            'month'      => $start,
            'prev_month' => $start->copy()->subMonth()->format('Y-m'),
            'next_month' => $start->copy()->addMonth()->format('Y-m'),
            'weeks'      => $weeks,
            'days'       => $days,
        ];
    }

    /**
     * その日に 1 時間でも空き枠があれば true を返す
     */
    private function isDayAvailable($blockedSlots, $dayEvents, $dayRes, int $capacity): bool
    {
        foreach (range(9, 22) as $hour) {
            // 1. 管理者都合ブロック
            if ($blockedSlots->contains(fn($s) => (int)$s->hour === $hour)) {
                continue;
            }

            // 2. イベント貸し切り（start <= hour < end）
            $isEventBlocked = $dayEvents->contains(function ($ev) use ($hour) {
                $sh = (int) substr($ev->start_time, 0, 2);
                $eh = (int) substr($ev->end_time,   0, 2);
                return $sh <= $hour && $hour < $eh;
            });
            if ($isEventBlocked) {
                continue;
            }

            // 3. 席数上限（仮予約・確定済みの人数合計 >= capacity）
            $used = $dayRes->filter(function ($r) use ($hour) {
                $sh = (int) substr($r->start_time, 0, 2);
                $eh = (int) substr($r->end_time,   0, 2);
                return $sh <= $hour && $hour < $eh;
            })->sum('num_people');
            if ($used >= $capacity) {
                continue;
            }

            return true;
        }

        return false;
    }
}
