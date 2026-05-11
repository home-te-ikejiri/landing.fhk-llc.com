<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use Illuminate\Http\Request;
use App\Services\Admin\EventService;

class EventController extends Controller
{
    public function __construct(private EventService $service)
    {
    }

    public function index(Request $request)
    {
        $records        = $this->service->fetchEvents();
        $content_header = $this->service->breadcrumb($request, 'index');
        return view('admin/event/event-list', compact('content_header', 'records'));
    }

    public function create(Request $request)
    {
        $content_header = $this->service->breadcrumb($request, 'create');
        return view('admin/event/create', compact('content_header'));
    }

    public function store(EventRequest $request)
    {
        $this->service->upsert($request);
        return redirect('admin/event')->with('status', '登録しました');
    }

    public function show(Request $request, string $id)
    {
        return redirect('admin/event/' . $id . '/edit');
    }

    public function edit(Request $request, string $id)
    {
        $record         = $this->service->fetchEventById($id);
        $content_header = $this->service->breadcrumb($request, 'edit');
        return view('admin/event/edit', compact('content_header', 'record'));
    }

    public function update(EventRequest $request, string $id)
    {
        $this->service->upsert($request);
        return redirect('admin/event')->with('status', '更新しました');
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->json(['result' => 'ok']);
    }
}
