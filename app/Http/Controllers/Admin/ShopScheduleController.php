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

    public function bulkUpdate(Request $request)
    {
        $dates  = $request->input('dates', []);
        $status = (int) $request->input('status', 0);
        $memo   = $request->input('memo') ?: null;

        if (empty($dates)) {
            return response()->json(['message' => '日付が選択されていません'], 422);
        }

        // 日付形式の簡易バリデーション
        foreach ($dates as $date) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return response()->json(['message' => '不正な日付形式です'], 422);
            }
        }

        if (!in_array($status, [0, 1, 2], true)) {
            return response()->json(['message' => '不正なステータスです'], 422);
        }

        $this->service->bulkUpdate($dates, $status, $memo);

        return response()->json(['message' => '一括変更しました', 'count' => count($dates)]);
    }
}
