<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalRoomScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\Admin\RentalRoomScheduleService;

class RentalRoomScheduleController extends Controller
{
    public function __construct(private RentalRoomScheduleService $service)
    {
    }

    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = Carbon::now()->format('Y-m');
        }

        $days           = $this->service->getMonthSchedules($month);
        $content_header = $this->service->breadcrumb($request, 'index');

        return view('admin/rental-room-schedule/index', compact('content_header', 'days', 'month'));
    }

    public function store(RentalRoomScheduleRequest $request)
    {
        $this->service->saveMonth($request);
        $month = $request->input('month');
        return redirect("admin/rental-room-schedule?month={$month}")->with('status', '保存しました');
    }
}
