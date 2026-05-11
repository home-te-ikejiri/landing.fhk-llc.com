<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\Admin\Service;
use App\Models\RentalRoomSchedule;

class RentalRoomScheduleService extends Service
{
    public function __construct(RentalRoomSchedule $model)
    {
        $this->_title = 'レンタルルームスケジュール';
        $this->index  = 'スケジュール管理';
        parent::__construct($model);
    }

    /**
     * 指定月の全日分スケジュールを返す（未登録日はダミーレコード）
     */
    public function getMonthSchedules(string $month): array
    {
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $records = $this->model
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->keyBy(fn($r) => $r->date->format('Y-m-d'));

        $days = [];
        $current = $start->copy();
        while ($current <= $end) {
            $dateStr = $current->toDateString();
            $days[]  = $records->get($dateStr) ?? (object)[
                'id'     => null,
                'date'   => Carbon::parse($dateStr),
                'status' => RentalRoomSchedule::STATUS_UNREGISTERED,
                'memo'   => null,
            ];
            $current->addDay();
        }

        return $days;
    }

    /**
     * 月内の全日分を一括 upsert
     */
    public function saveMonth(Request $request): void
    {
        foreach ($request->schedules as $row) {
            $this->model->updateOrCreate(
                ['date' => $row['date']],
                [
                    'status' => $row['status'],
                    'memo'   => $row['memo'] ?? null,
                ]
            );
        }
    }
}
