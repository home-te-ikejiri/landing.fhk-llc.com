<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalRoomTimeSlotRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\Admin\RentalRoomTimeSlotService;

class RentalRoomTimeSlotController extends Controller
{
    public function __construct(private RentalRoomTimeSlotService $service)
    {
    }

    /**
     * 指定日の時間枠管理画面
     * GET /admin/rental-room-time-slot/{date}
     */
    public function show(Request $request, string $date)
    {
        // 日付形式バリデーション
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            abort(404);
        }

        $slots          = $this->service->getSlots($date);
        $dateObj        = Carbon::parse($date);
        $content_header = $this->service->breadcrumb($request, 'edit');
        $backMonth      = $dateObj->format('Y-m');

        return view('admin/rental-room-time-slot/show',
            compact('content_header', 'slots', 'date', 'dateObj', 'backMonth'));
    }

    /**
     * 時間枠を保存
     * POST /admin/rental-room-time-slot
     */
    public function store(RentalRoomTimeSlotRequest $request)
    {
        $this->service->saveSlots($request);
        $date  = $request->input('date');
        $month = Carbon::parse($date)->format('Y-m');
        return redirect("admin/rental-room-time-slot/{$date}")
            ->with('status', '時間枠を保存しました');
    }
}
