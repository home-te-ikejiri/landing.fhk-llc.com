<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalRoomReservationRequest;
use Illuminate\Http\Request;
use App\Services\Admin\RentalRoomReservationService;

class RentalRoomReservationController extends Controller
{
    public function __construct(private RentalRoomReservationService $service)
    {
    }

    public function index(Request $request)
    {
        $records        = $this->service->fetchList($request);
        $content_header = $this->service->breadcrumb($request, 'index');
        $statusLabels   = RentalRoomReservationService::STATUS_LABELS;
        return view('admin/rental-room-reservation/index',
            compact('content_header', 'records', 'statusLabels'));
    }

    public function create(Request $request)
    {
        $content_header  = $this->service->breadcrumb($request, 'create');
        $statusLabels    = RentalRoomReservationService::STATUS_LABELS;
        $usageTypeLabels = RentalRoomReservationService::USAGE_TYPE_LABELS;
        $purposeLabels   = RentalRoomReservationService::PURPOSE_LABELS;
        return view('admin/rental-room-reservation/create',
            compact('content_header', 'statusLabels', 'usageTypeLabels', 'purposeLabels'));
    }

    public function store(RentalRoomReservationRequest $request)
    {
        $this->service->upsert($request);
        return redirect('admin/rental-room-reservation')->with('status', '登録しました');
    }

    public function show(Request $request, string $id)
    {
        return redirect("admin/rental-room-reservation/{$id}/edit");
    }

    public function edit(Request $request, string $id)
    {
        $record          = $this->service->fetchById($id);
        $content_header  = $this->service->breadcrumb($request, 'edit');
        $statusLabels    = RentalRoomReservationService::STATUS_LABELS;
        $usageTypeLabels = RentalRoomReservationService::USAGE_TYPE_LABELS;
        $purposeLabels   = RentalRoomReservationService::PURPOSE_LABELS;
        return view('admin/rental-room-reservation/edit',
            compact('content_header', 'record', 'statusLabels', 'usageTypeLabels', 'purposeLabels'));
    }

    public function update(RentalRoomReservationRequest $request, string $id)
    {
        $this->service->upsert($request);
        return redirect('admin/rental-room-reservation')->with('status', '更新しました');
    }

    public function destroy(string $id)
    {
        $this->service->updateStatus($id, \App\Models\RentalRoomReservation::STATUS_CANCELLED);
        return response()->json(['result' => 'ok']);
    }
}
