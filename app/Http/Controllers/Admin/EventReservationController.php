<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventReservationRequest;
use Illuminate\Http\Request;
use App\Services\Admin\EventReservationService;

class EventReservationController extends Controller
{
    public function __construct(private EventReservationService $service)
    {
    }

    public function index(Request $request)
    {
        $records        = $this->service->fetchList($request);
        $content_header = $this->service->breadcrumb($request, 'index');
        $statusLabels   = EventReservationService::STATUS_LABELS;
        $events         = $this->service->fetchAllEvents();
        return view('admin/event-reservation/index',
            compact('content_header', 'records', 'statusLabels', 'events'));
    }

    public function create(Request $request)
    {
        $content_header = $this->service->breadcrumb($request, 'create');
        $statusLabels   = EventReservationService::STATUS_LABELS;
        $events         = $this->service->fetchAllEvents();
        return view('admin/event-reservation/create',
            compact('content_header', 'statusLabels', 'events'));
    }

    public function store(EventReservationRequest $request)
    {
        $this->service->upsert($request);
        return redirect('admin/event-reservation')->with('status', '登録しました');
    }

    public function show(Request $request, string $id)
    {
        return redirect("admin/event-reservation/{$id}/edit");
    }

    public function edit(Request $request, string $id)
    {
        $record         = $this->service->fetchById($id);
        $content_header = $this->service->breadcrumb($request, 'edit');
        $statusLabels   = EventReservationService::STATUS_LABELS;
        $events         = $this->service->fetchAllEvents();
        return view('admin/event-reservation/edit',
            compact('content_header', 'record', 'statusLabels', 'events'));
    }

    public function update(EventReservationRequest $request, string $id)
    {
        $this->service->upsert($request);
        return redirect('admin/event-reservation')->with('status', '更新しました');
    }

    public function destroy(string $id)
    {
        $this->service->updateStatus($id, \App\Models\EventReservation::STATUS_CANCELLED);
        return response()->json(['result' => 'ok']);
    }
}
