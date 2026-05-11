<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\Service;
use App\Models\RentalRoomTimeSlot;

class RentalRoomTimeSlotService extends Service
{
    // 管理対象とする時間帯（9〜22時）
    const HOURS = [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22];

    public function __construct(RentalRoomTimeSlot $model)
    {
        $this->_title = 'レンタルルーム時間枠管理';
        $this->edit   = '時間枠管理';
        parent::__construct($model);
    }

    /**
     * 指定日の時間枠一覧を返す（DBにないhourはis_blocked=0のダミー）
     */
    public function getSlots(string $date): array
    {
        $records = $this->model
            ->where('date', $date)
            ->get()
            ->keyBy('hour');

        $slots = [];
        foreach (self::HOURS as $hour) {
            $slots[] = $records->get($hour) ?? (object)[
                'id'         => null,
                'date'       => $date,
                'hour'       => $hour,
                'is_blocked' => false,
                'admin_memo' => null,
            ];
        }

        return $slots;
    }

    /**
     * 指定日の全時間枠を一括 upsert
     */
    public function saveSlots(Request $request): void
    {
        $date = $request->input('date');

        foreach ($request->input('slots', []) as $row) {
            $this->model->updateOrCreate(
                ['date' => $date, 'hour' => $row['hour']],
                [
                    'is_blocked' => $row['is_blocked'],
                    'admin_memo' => $row['admin_memo'] ?? null,
                ]
            );
        }
    }
}
