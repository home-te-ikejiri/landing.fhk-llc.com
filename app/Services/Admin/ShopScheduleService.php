<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\Admin\Service;
use App\Models\ShopSchedule;

class ShopScheduleService extends Service
{
    public function __construct(ShopSchedule $model)
    {
        $this->_title = '喫茶店スケジュール';
        $this->index  = 'スケジュール管理';
        parent::__construct($model);
    }

    /**
     * 指定月の全日分のスケジュールを返す（未登録日はダミーレコード）
     */
    public function getMonthSchedules(string $month): array
    {
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        // DBから該当月のデータを取得しdate keyed配列に
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
                'status' => ShopSchedule::STATUS_UNREGISTERED,
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
