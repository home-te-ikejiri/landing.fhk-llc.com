<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShopScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\Admin\ShopScheduleService;

class ShopScheduleController extends Controller
{
    public function __construct(private ShopScheduleService $service)
    {
    }

    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        // 月文字列の簡易バリデーション
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = Carbon::now()->format('Y-m');
        }

        $days           = $this->service->getMonthSchedules($month);
        $content_header = $this->service->breadcrumb($request, 'index');

        return view('admin/shop-schedule/index', compact('content_header', 'days', 'month'));
    }

    public function store(ShopScheduleRequest $request)
    {
        $this->service->saveMonth($request);
        $month = $request->input('month');
        return redirect("admin/shop-schedule?month={$month}")->with('status', '保存しました');
    }
}
